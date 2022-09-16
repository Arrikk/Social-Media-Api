<?php

namespace App\Views\components\dashboard;

use Core\Component;

class Dashboard extends Component
{
    public function _main($param = null)
    {
        echo '<div class="nk-block">
        <div class="row g-gs">';
        $param;
        echo '</div></div>';
    }
}
