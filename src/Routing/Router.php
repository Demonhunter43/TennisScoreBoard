<?php

namespace src\Routing;

use src\Controllers\Controller;

class Router
{

    public static function getController($url): Controller
    {
        $path = parse_url($url)["path"];
        $routes = require_once "routes.php";

        if (!array_key_exists($path, $routes)) {
            header("Location: http://localhost:8876/matches");
        }
        return $routes[$path];
    }
}