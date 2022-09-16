<?php
namespace App\Controllers\Admin;

use App\Controllers\Authenticated\Admin;
use Core\View;

class Referral extends Admin
{
    public function _index()
    {
        View::draw('referral/index', [
            'title' => 'Referrals',
            'page' => 'list'
        ]);
    }
    
    public function _details()
    {
        View::draw('referral/index', [
            'title' => 'Referrals',
            'page' => 'details'
        ]);
    }
}