<?php

namespace App\Controllers\Settings;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Settings\Privacy as ModelPrivacy;
use Core\Http\Res;

class Privacy extends Authenticated
{
    public function privacy($user)
    {
        if(isset($user->id) && isset($user->name)):
            $id = $this->isUser($user->id);
            if ($user->name == SHOW_ACTIVITY) :
                $name = SHOW_ACTIVITY;
            elseif ($user->name == SHOW_SUBSCRIPTION) :
                $name = SHOW_SUBSCRIPTION;
            else :
                Res::status(400)->json(['error' => "Invalid Request"]);
            endif;
            Res::json(['privacy' => ModelPrivacy::privacy($user->id, $name)]);
        else:
            Res::status(400)->json(['error' => 'Action Denied']);
        endif;
    }
}
