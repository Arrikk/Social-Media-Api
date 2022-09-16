<?php

namespace  App\Controllers\Others;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Referrals as ModelsReferrals;
use Core\Http\Res;

class Referrals extends Authenticated
{
    public function _action()
    {
        Res::send('Action');
    }

    public function _get($data)
    {
        $this->isAdmin();
        $Referrals = ModelsReferrals::Referrals($data);
        Res::json($Referrals);
    }

    public function _myRef($data)
    {
        Res::json(ModelsReferrals::referrals($data, $this->user->id));
    }
}
