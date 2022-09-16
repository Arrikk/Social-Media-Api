<?php
namespace App\Controllers\Admin;

use App\Controllers\Authenticated\Admin;
use Core\View;

class Withdrawal extends Admin
{
    public function _index()
    {
        // $this->_isAdmin();
        View::draw('withdrawal/index', [
            'title' => 'Withdrawals',
            'page' => 'list'
        ]);
    }
    
    public function _details()
    {
        // $this->_isAdmin();
        View::draw('withdrawal/index', [
            'title' => 'Withdrawals',
            'page' => 'details'
        ]);
    }
}