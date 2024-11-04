<?php

namespace src\Routing;

use src\Controllers\Controller;
use src\Http\Request;

class Router
{

    public static function getController(Request $request): Controller
    {
        $uri = $request->getUri();
        $httpMethod = $request->getMethod();
        $path = parse_url($uri)["path"];
        $routes = require_once "routes.php";

        if (!array_key_exists($path, $routes) && self::isValidHttpMethod($httpMethod)) {
            header("Location: http://localhost:8876/matches");
        }
        return $routes[$path];
    }

    public static function isValidHttpMethod(string $httpMethod): bool
    {
        return ($httpMethod == "POST") || ($httpMethod == "GET");
    }
}