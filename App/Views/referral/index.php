<?php

use App\Views\components\referral\Referral;

if($page == LISTS) Referral::main();
if($page == DETAILS) Referral::details();