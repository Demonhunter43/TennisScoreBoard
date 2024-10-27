<?php

namespace src\App;

use src\Routing\Router;

class App
{
    public function __construct()
    {
    }

    public function run(): void
    {
        if (!array_key_exists('REQUEST_URI', $_SERVER)) {
            header("Location: http://localhost:8876/matches");
            exit();
        }
        $url = $_SERVER['REQUEST_URI'];
        $router = new Router($url);
        $controller = $router->getController();
        $controller->run();
    }
}