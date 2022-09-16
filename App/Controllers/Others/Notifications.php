<?php
namespace App\Controllers\Others;

use App\Controllers\Authenticated\Authenticated;
use App\Models\User\Notifications as UserNotifications;
use Core\Http\Res;

class Notifications extends Authenticated
{
    public function _my($data)
    {
        Res::json(UserNotifications::myNotifications($this->user->id, $data));
    }
}