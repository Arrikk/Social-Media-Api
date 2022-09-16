<?php

namespace App\Models\Feed;

use App\Models\User;
use App\Models\User\Notifications;
use App\Models\Wallet\Transactions;
use App\Models\Wallet\Wallet;
use Core\Http\Res;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class Tips extends Model
{
    use TraitsModel;
    static $table = 'tips';

    public static function make($data)
    {
        # Check if user balance is sufficient
        Wallet::isAvailableBalance($data->id, $data->amount);
        # get the feed
        $feed = Feed::feedById($data->feed);

        $amount = (float) $data->amount;
        # create Record for tip
        $tips = self::dump([
            'user_id' => $data->id,
            'beneficiary' => $feed->user_id,
            'feed_id' => $data->feed,
            'amount' => $amount,
            'description' => $data->description ?? '',
        ]);
       
        # Debit current user
        $currentUserWallet = Wallet::fundWallet($data, DEDUCTION);
       
        # Credit beneficiary
        $authorWallet = Wallet::fundWallet(null, ADDITION, $amount, $feed->user_id);
        
        # Record earning for beneficiary
         Transactions::record([
            'user' => $feed->user_id,
            'description' => 'You received a feed tip',
            'amount' => $amount,
            'type' => TIP,
            'status' => CREDIT
        ]);

        # Record Transacstion for Current User
        Transactions::record([
            'user' => $data->id,
            'description' => 'You sent a feed tip',
            'amount' => $amount,
            'type' => TIP,
            'status' => DEBIT
        ]);

        # notify beneficiary on tips
        Notifications::notify([
            'description' => 'Tipped your feed +$'.$amount,
            'user' => $feed->user_id,
            'agent' => $data->id,
            'category' => TIP
        ]);
        
        return (object) [
            'tipAmount' => (int) $tips->amount,
            'balance' => $currentUserWallet->balance,
            'discription' => $tips->description
        ];
    }

    public static function tipUser($tip)
    {
        # Confirm user exists
        User::getUserMinified($tip->beneficiary);
        #Check if user has sufficient fund
        Wallet::isAvailableBalance($tip->currentUser, $tip->amount);
        $amount = (float) $tip->amount;
        # Create Tip record
        $tips = self::dump([
            'user_id' => $tip->currentUser,
            'beneficiary' => $tip->beneficiary,
            'amount' => $amount,
            'description' => $tip->description ?? '',
        ]);
        # Debit current user
        $currentUserWallet = Wallet::fundWallet(null, DEDUCTION, $amount, (int) $tip->currentUser);
       
        # Credit beneficiary
        $authorWallet = Wallet::fundWallet(null, ADDITION, $amount, (int) $tip->beneficiary);
       
        # Record earning for beneficiary
        Transactions::record([
            'user' => $tip->beneficiary,
            'description' => 'You received a tip',
            'amount' => $amount,
            'type' => TIP,
            'status' => CREDIT
        ]);

        # Record Transacstion for Current User
        Transactions::record([
            'user' => $tip->currentUser,
            'description' => 'You sent a tip',
            'amount' => $amount,
            'type' => TIP,
            'status' => DEBIT
        ]);
        
        # Notify Beneficiary about tipp
        Notifications::notify([
            'description' => 'Tipped your Profile +$'.$amount,
            'user' => $tip->beneficiary,
            'agent' => $tip->currentUser,
            'category' => TIP
        
        ]);
        return (object) [
            'tipAmount' => $amount,
            'balance' => $currentUserWallet->balance,
            'discription' => $tips->description
        ];
    }

    public static function referrals($extra = null)
    {
        $currentPage = $extra->page ?? 1;
        $currentPage = (int) $currentPage;
        $limit = $extra->limit ?? LIMIT;
        $order = $extra->order ?? DESC;


        if ($currentPage < 1) $currentPage = 1;
        $startAt = ($currentPage - 1) * $limit;

        $qry = 'referrals.id, referrals.user_id, referrals.referral_code, referrals.reffered_by, referrals.createdAt, referrals.updatedAt, u.username, u.email, u.display_name as name';

        return self::find([
            '$.left' => 'users u',
            '$.on' => 'referrals.user_id = u.id',
            '$.order' => "id $order",
            '$.limit' => "$startAt, $limit"
        ], $qry);
    }

    public static function tipsAmount($feedId)
    {
        $tips = static::find(['feed_id' => $feedId], 'sum(amount) as totalTips');
        return $tips[0]->totalTips;
    }
}
