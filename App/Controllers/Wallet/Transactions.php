<?php
namespace App\Controllers\Wallet;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Wallet\Transactions as WalletTransactions;
use Core\Http\Res;

class Transactions extends Authenticated
{
    public function _myEarnings($data)
    {
        Res::json(WalletTransactions::myEarnings($this->user->id));
    }

}