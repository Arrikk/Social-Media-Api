<?php
namespace App\Models;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class Referrals extends Model
{
    use TraitsModel;
    static $table = 'referrals';

    public static function make($data)
    {
        $referralCode = self::generateReferralCode($data->display_name);
        self::dump([
            'user_id' => $data->id,
            'referral_code' => $referralCode,
            'referred_by' => $data->referralCode,
        ]);
    }

    public static function generateReferralCode($name)
    {
        // generate crypto secure byte string
            $bytes = random_bytes(6);
            // convert to alphanumeric (also with =, + and /) string
            $encoded = base64_encode($bytes);
            // remove the chars we don't want
            $stripped = str_replace(['=', '+', '/'], '', $encoded);
            // get the prefix from the user name
            $prefix = strtolower(substr($name, 0, 3));
            // format the final referral code
            $referralCode = ($prefix . $stripped);
            $exists = self::findOne(['referral_code' => $referralCode]);
            if(!$exists) return $referralCode;
            self::generateReferralCode($name);
    }

    public static function referrals($extra = null, $user = null)
    {
        $currentPage = $extra->page ?? 1;
        $currentPage = (int) $currentPage;
        $limit = $extra->limit ?? LIMIT;
        $order = $extra->order ?? DESC;

        
        if($currentPage < 1) $currentPage = 1;
        $startAt = ($currentPage -1) * $limit;

        $qry = 'referrals.id, referrals.user_id, referrals.referral_code, referrals.referred_by, referrals.createdAt, referrals.updatedAt, u.username, u.email, u.display_name as name';

        # My referrals
        if($user):
            $user = self::findOne(['user_id' => $user]);
            $referrals = self::find(['referred_by' => $user->referral_code]);
            foreach ($referrals as $key => $referral) :
                $referrals[$key] = User::getUserMinified($referral->user_id);
            endforeach;
            
            return $referrals;
        endif;

       return self::find([
            '$.left' => 'users u',
            '$.on' => 'referrals.user_id = u.id',
            '$.order' => "id $order",
            '$.limit' => "$startAt, $limit"
        ], $qry);
    }

    public static function referralsCount($limit = null)
    {
        $totalreferrals = static::find([], 'count(*) as totalreferrals');
        return [
            'total' => $totalreferrals[0]->totalreferrals,
            'limit' => $limit->limit ?? LIMIT
        ];
    }
}