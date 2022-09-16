<?php
namespace App\Models\Wallet;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class Bank extends Model
{
    use TraitsModel;
    static $table = 'bankdetails';

    public static function bankDetails($id)
    {
        return self::findOne([
            'user_id' => $id,
        ], 'name as accountName, nuban, bank, createdAt as addedOn, updatedAt as updatedOn ');
    }
}

