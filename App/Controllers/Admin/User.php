<?php
namespace App\Controllers\Admin;

use App\Controllers\Authenticated\Authenticated;
use Core\Http\Res;

class User extends Authenticated
{
    public function index()
    {
        Res::send('User');
    }
}