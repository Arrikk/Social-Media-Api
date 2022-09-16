<?php

use App\Views\components\dashboard\Dashboard;
use Core\View;

echo '<div class="nk-block">
<div class="row g-gs">';
Dashboard::render(
    View::component('dashboard/top-withdrawals'),
    View::component('dashboard/browser'),
    View::component('dashboard/session'),
    View::component('dashboard/traffic')
);
echo '</div></div>';
