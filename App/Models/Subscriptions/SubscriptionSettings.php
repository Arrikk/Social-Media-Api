<?php
namespace App\Models\Subscriptions;

use Core\Http\Res;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class SubscriptionSettings extends Model
{
    use TraitsModel;
    static $table = 'subscription_setting';

    /**
     * Set user subscription
     * @param int $userId id of user subscription setting to set
     * @return object
     */
    public static function set($userId)
    {
        $monthly = date('y-m-d H:i:s', strtotime('+30days'));
        return self::dump([
            'user_id' => $userId,
            'amount' => 0,
            'duration' => $monthly
        ]);
    }

    /**
     * Update a user subscription settings
     * @param int $user user to update
     * @param int $amount user amount to set
     * @return object
     */
    public static function updateSubscription($user, $amount)
    {
        $update = self::findAndUpdate(['user_id' => $user], ['amount' => $amount]);
        if(!$update) Res::status(400)->json(['error' => 'Operation Canceled']);
        return self::subSettings($update->user_id);
    }

    /**
     * Get the subscription settings of a user
     * @param int $user id of the user subscription to get
     * @return object
     */
    public static function subSettings($user)
    {
        $subSetting = self::findOne(['user_id' => $user]);
        return (object) [
            'subscriptionId' => $subSetting->id,
            'userId' => $subSetting->user_id,
            'amount' => $subSetting->amount,
            'subscriptionAmount' => "$".$subSetting->amount,
            'subscriptionStatus' => $subSetting->status,
            'isActive' => $subSetting->status == ACTIVE ? true : false,
            'isPending' => $subSetting->status == PENDING ? true : false,
            'isPaused' => $subSetting->status == PAUSED ? true : false,
            'isFree' => $subSetting->amount <= 0 ? true : false
        ];
    }


}