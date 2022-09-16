<?php

use App\Views\components\users\Users;

if($page == LISTS) Users::main();
if($page == DETAILS) Users::details();