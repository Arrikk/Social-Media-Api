<?php

namespace App\Models\Subscriptions;

use App\Models\User;
use App\Models\User\Friends;
use App\Models\User\Notifications;
use App\Models\Wallet\Transactions;
use App\Models\Wallet\Wallet;
use Core\Http\Res;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class Subscriptions extends Model
{
    use TraitsModel;
    static $table = 'subscriptions';

    /**
     * Subscribe to a user and become friends with them
     * @param int $ownerId > id of the user to subscribe to
     * @param int $subscriber > id of the user making subscription
     * @return object
     */
    public static function subscribe($ownerId, $subscriber)
    {
        # Verify if user is not subscriber
        if ($ownerId == $subscriber) Res::status(400)->json(['error' => 'You cannot subscribe to ur profile...']);
        # Verify user exists
        User::getUserMinified($ownerId);

        #Verify Subsctiption doesnt exist or is not expired
        $needsRenewal = self::isSubscribedAndIsActive($ownerId, $subscriber);

        # get the author > author account subscription setting
        $sub = SubscriptionSettings::subSettings($ownerId);

        # check if author has set subscription to free
        # if subscription is free Prceed to follow / subscribe without further checks
        if ($sub->isFree) return self::activateSubscription($sub, $subscriber, $needsRenewal);

        # check if subscriber has sufficient balance to subscribe
        $wlt = Wallet::isAvailableBalance($subscriber, $sub->amount);

        # Activate user Subscription
        $activated = self::activateSubscription($sub, $subscriber, $needsRenewal);

        $amount = $sub->amount;

        # debit subscriber wallet
        Wallet::fundWallet(null, DEDUCTION, $amount, $subscriber);

        # Credit author wallet 
        Wallet::fundWallet(null, ADDITION, $amount, $sub->userId);

        # Record Transacstion for Current User
        Transactions::record([
            'user' => $subscriber,
            'description' => 'Profile subscription',
            'amount' => $amount,
            'type' => SUBSCRIPTION,
            'status' => DEBIT
        ]);

        # Record Transacstion for Current User
        Transactions::record([
            'user' =>  $sub->userId,
            'description' => 'Someone subscribed to your profile',
            'amount' => $amount,
            'type' => SUBSCRIPTION,
            'status' => CREDIT
        ]);

        
        Res::json($activated);
    }

    /**
     * unsubscribe
     * @param int $ownerId > id of the user to subscribe to
     * @param int $subscriber > id of the user making subscription
     * @return object
     */
    public static function unsubscribe($ownerId, $subscriber)
    {
        $nextMonth = date('y-m-d H:i:s', time() - 12);
        $currentDate = date('y-m-d H:i:s');
        $sub = self::findAndUpdate(['user_id' => $ownerId, 'and.subscriber' => $subscriber], [
            'expiry' => $nextMonth,
            'updatedAt' => $currentDate
        ]);
        return self::subscription($sub->subscriber, $sub->user_id);
    }

    /**
     * Activate user subscription if above checks are passed
     * @param object $data.. the subscription setting data
     * @param int $subscriber the subscriber id... who is making subscription
     * @return object
     */
    public static function activateSubscription($data, $subscriber, $needRenewal = true)
    {
        $nextMonth = date('y-m-d H:i:s', strtotime('+30days'));
        $currentDate = date('y-m-d H:i:s');

        

        # set user subscription... add to subscription list

        #If user subscription exists but needs update
        if ($needRenewal) :
            // Res::send('Updating');
            $sub = self::findAndUpdate(['user_id' => $data->userId, 'and.subscription_id' => $data->subscriptionId], [
                'subscription_id' => $data->subscriptionId,
                'user_id' => $data->userId,
                'subscriber' => $subscriber,
                'expiry' => $nextMonth,
                'updatedAt' => $currentDate
            ]);
        else :
            // Res::send('Creating');
            $sub = self::dump([
                'subscription_id' => $data->subscriptionId,
                'user_id' => $data->userId,
                'subscriber' => $subscriber,
                'expiry' => $nextMonth,
                'updatedAt' => $currentDate
            ]);

            # Follow or unfollow a user
            $folowings = Friends::friend((object) [
                'toFollow' => (int) $data->userId,
                'isFollowing' => (int) $subscriber
            ]);
        endif;

        # Notify user anout subscription to their profile
        Notifications::notify([
            'description' => 'Subscribed to your channel',
            'user' => $sub->user_id,
            'agent' => $subscriber,
            'category' => SUBSCRIPTION
        ]);
        
        return self::subscription($sub->subscriber, $sub->user_id);



    }

    public static function subscription($subscriber, $owner)
    {
        $subscription = self::findOne(['user_id' => $owner, 'and.subscriber' => $subscriber]);
        if (!$subscription) return false;
        return (object) [
            'subscriptionId' => $subscription->id,
            'subscriberId' => $subscription->subscriber,
            'subscriptionSettingId' => $subscription->subscription_id,
            'isExpired' => strtotime($subscription->expiry) < time() ? true : false,
            'needsRenewal' => strtotime($subscription->expiry) < time() ? true : false,
            'lastRenewedOn' => $subscription->updatedAt,
            'subscribedOn' => $subscription->createdAt,
            'nextRenewalDate' => $subscription->expiry
        ];
    }

    /** 
     * Check is subscriber is already subscribed
     * @param int $owner .. id of the subscription owner
     * @param int $subscriber .. id of subscriber
     * @return bool
     */
    public static function isSubscribed($ownerId, $subscriber)
    {
        $isUserSubscribed = Subscriptions::subscription($subscriber, $ownerId);
        if ($isUserSubscribed) return true;
        else return false;
    }

    /**
     * Check if subsctiption exists and not expired
     * @param int $profile...
     * @param int $subscriber
     * @return mixed
     */
    public static function isSubscribedAndIsActive($profile, $subscriber)
    {
        $sub = self::subscription($subscriber, $profile);
        if ($sub && !$sub->isExpired) Res::status(400)->json(['error' => 'You have an active subscription']);
        if($sub && $sub->isExpired) return true;
        return false;
    }

    /**
     * Get my current subscriptions
     * @param int current user id
     * @return mixed
     */
    public static function mySubscriptions($subscriber)
    {
        $subscriptions = self::find(['subscriber' => $subscriber]);
        foreach($subscriptions as $key => $sub):
            $subscriptions[$key] = User::getUser($sub->user_id, $sub->subscriber);
        endforeach;
        return $subscriptions;
    }
}
