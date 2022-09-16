<?php

use App\Views\components\withdrawal\Withdrawal;

if($page == LISTS) Withdrawal::main();
if($page == DETAILS) Withdrawal::details();