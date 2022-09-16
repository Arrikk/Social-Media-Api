<?php
namespace App\Models\Wallet;

use App\Models\User;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class Transactions extends Model
{
    use TraitsModel;
    static $table = 'transactions';

    public static function record($data)
    {
        extract($data);
        return self::dump([
            'description' => self::clean(nl2br($description)),
            'amount' => $amount,
            'user_id' => $user,
            'status' => $status,
            'type' => $type
        ]);
    }

    public static function myEarnings($user)
    {
        $earnings = self::find(['user_id' => $user]);

        foreach ($earnings as $key => $value) {
            $earnings[$key] = [
                'description' => html_entity_decode($value->description),
                'amount' => (float) $value->amount,
                'isCredit' => $value->status == CREDIT,
                'isDebit' => $value->status == DEBIT,
                'isForTip' => $value->type == TIP,
                'isForSubscription' => $value->type == SUBSCRIPTION,
                'isForFeed' => $value->type == FEED,
                'isForPost' => $value->type == POST,
            ];
        }
        
        return $earnings;
    }

    public static function transactionByUser($userId)
    {
        $user = User::getUserMinified($userId);
        $transactions = self::find(['user_id' => $user->id]);

        return [
            'user' => $user,
            'transactions' => $transactions
        ];
    }
}