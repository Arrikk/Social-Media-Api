<?php

namespace App\Controllers\Settings;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Settings\Display as SettingsDisplay;
use App\Models\Settings\Privacy;
use Core\Http\Res;

class Display extends Authenticated
{
    public function _display($user)
    {
        if (!isset($user->id))
            Res::status(400)->json(['error' => "Action denied"]);
        $id = $this->isUser($user->id);
        Res::json(['display' => SettingsDisplay::display($user->id)]);
    }
}
