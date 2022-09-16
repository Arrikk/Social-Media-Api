<?php

namespace App\Models\Wallet;

use Core\Http\Res;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class Wallet extends Model
{
    use TraitsModel;
    static $table = 'wallet';

    public static function createWallet($id)
    {
        return static::dump([
            'user_id' => $id,
        ]);
    }

    public static function fundWallet($data, $operator = '+', $amount = null, $user = null)
    {
        $amount = preg_replace('/[^\d.]+/', '', $data->amount ?? $amount);
        return self::findAndUpdate(
            ['user_id' => $data->id ?? $user],
            ['balance' => (int) $amount],
            ['name' => static::$math, 'operator' => $operator]
        );
    }

    public static function getWallet($userId)
    {
        return self::findOne([
            'user_id' => $userId
        ], 'balance, withdrawable as pending');
    }

    public static function isAvailableBalance($userId, $amount)
    {
        $wallet = self::getWallet($userId);
        if ((int) $wallet->balance > (int) $amount)
            return $wallet;
        Res::status(400)->json(['error' => 'Insufficient Balance']);
    }

    public static function recordTxn()
    {
    }
}
