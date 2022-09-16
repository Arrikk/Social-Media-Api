<?php

namespace App\Controllers\Settings;

use App\Controllers\Authenticated\Authenticated;
use Core\Http\Res;

class Email extends Authenticated
{
    public function _email($user)
    {
        if (!isset($user->id))
            Res::status(400)->json(['error' => "Action denied"]);
        $this->isUser($user->id);

        Res::json(['email' => "Email Settings"]);
    }
}
