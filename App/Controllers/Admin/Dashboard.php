<?php
namespace App\Controllers\Admin;

use App\Controllers\Authenticated\Admin;
use Core\Controller;
use Core\View;

class Dashboard extends Admin
{
    public function _index()
    {
        View::draw('dashboard/index', ['title' => 'Dashboard']);
    }
}