<?php
namespace App\Controllers\Admin;

use App\Controllers\Authenticated\Authenticated;
use Core\Http\Res;

class Consultant extends Authenticated
{
    public function index()
    {
        Res::send('Consultant');
    }
}