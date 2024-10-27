<?php

namespace src\Routing;

use src\Controllers\Controller;

class Router
{
    private string $url;


    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getController(): Controller
    {
        $path = parse_url($this->url)["path"];
        $routes = require_once "routes.php";

        if(!array_key_exists($path, $routes)){
            header("Location: http://localhost:8876/matches");
        }
        return $routes[$path];
    }
}