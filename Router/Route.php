<?php

namespace Router;

use Core\Router;

class Route
{

    public static function Route()
    {

        $router = new Router;
        require __DIR__.'/Routes.php';
        require 'App/Variables.php';
        
        /**
         * Match the Requested Url
         */
        $url = rtrim(ltrim($_SERVER['QUERY_STRING']));
        $router->dispatch($url);
    }
}
