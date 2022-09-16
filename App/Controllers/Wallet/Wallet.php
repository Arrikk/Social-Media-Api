<?php
namespace App\Controllers\Wallet;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Wallet\Wallet as WalletWallet;
use Core\Http\Res;

class Wallet extends Authenticated
{
    public function _fund($data)
    {
        if(isset($data->id) 
        && !empty($data->id) 
        && isset($data->amount) 
        && !empty($data->amount)):
        $this->isUser($data->id);
            Res::json(WalletWallet::fundWallet($data));
        endif;
    }

    public function _myWallet()
    {
        Res::json(WalletWallet::getWallet($this->user->id));
    }
}