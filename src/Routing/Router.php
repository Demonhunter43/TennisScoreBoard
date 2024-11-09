<?php

namespace src\Routing;

use src\Controllers\Controller;
use src\Http\Request;

class Router
{

    public static function getController(Request $request): Controller
    {
        $httpMethod = $request->getMethod();
        $parsedUri = parse_url($request->getUri());
        $routes = require_once "routes.php";

        if (!array_key_exists($parsedUri["path"], $routes) && self::isValidHttpMethod($httpMethod)) {
            header("Location: http://localhost:8876/matches");
        }
        return $routes[$parsedUri["path"]];
    }

    public static function isValidHttpMethod(string $httpMethod): bool
    {
        return ($httpMethod == "POST") || ($httpMethod == "GET");
    }
}