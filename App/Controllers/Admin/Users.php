<?php
namespace App\Controllers\Admin;

use App\Controllers\Authenticated\Admin;
use Core\Http\Res;
use Core\View;

class Users extends Admin 
{
    public function _index()
    {
        View::draw('users/index', [
            'title' => 'Users',
            'page' => LISTS
        ]);
    }
    public function _details()
    {
        View::draw('users/index', [
            'title' => 'Users',
            'page' => DETAILS
        ]);
    }
}