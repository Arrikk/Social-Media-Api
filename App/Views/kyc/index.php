<?php

use App\Views\components\kyc\Kyc;
use Core\View;

if($page == LISTS) Kyc::render(
    View::component('kyc/list/head'),
    View::component('kyc/list/body'),
);

if($page == DETAILS) Kyc::render(
    View::component('kyc/details/head'),
    View::component('kyc/details/body'),
    View::component('kyc/details/imagemodal'),
);