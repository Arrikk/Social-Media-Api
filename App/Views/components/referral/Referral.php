<?php
namespace App\Views\components\referral;

use Core\Component;
use Core\View;

class Referral extends Component
{
    public function _main()
    {
        self::render(
            View::component('referral/list/head'),
            View::component('referral/list/body')
        );
    }

    public function _details()
    {
        self::render(
            View::component('referral/details/head'),
            View::component('referral/details/body')
        );
    }
}