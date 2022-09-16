<?php
namespace App\Controllers\Admin;

use App\Controllers\Authenticated\Authenticated;
use Core\Http\Res;

class Events extends Authenticated
{
    public function index()
    {
        Res::send('Events');
    }
}