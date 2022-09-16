<?php
namespace App\Controllers\Admin;

use App\Controllers\Authenticated\Admin;
use Core\View;

class Kyc extends Admin
{
    public function _index()
    {
        View::draw('kyc/index', [
            'title' => 'KYC Documents',
            'page' => LISTS
        ]);
    }

    public function _details()
    {
        View::draw('kyc/index', [
            'title' => 'KYC Documents Details',
            'page' => DETAILS
        ]);
    }
}