<?php
namespace App\Views\components\kyc;

use Core\Component;
use Core\Http\Res;
use Core\View;

class Kyc extends Component
{
    public function _main()
    {
        View::component('kyc/list');
    }

    public function _head()
    {
        View::component('kyc/head');
    }

    public function _body()
    {
        View::component('kyc/body');
    }
}