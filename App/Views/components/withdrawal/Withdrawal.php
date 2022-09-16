<?php
namespace App\Views\components\withdrawal;

use Core\Component;
use Core\View;

class Withdrawal extends Component
{
    public function _main()
    {
        self::render(
            View::component('withdrawal/list/head'),
            View::component('withdrawal/list/body')
        );
    }

    public function _details()
    {
        self::render(
            View::component('withdrawal/details/head'),
            View::component('withdrawal/details/body')
        );
    }
}