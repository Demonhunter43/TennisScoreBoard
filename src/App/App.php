<?php

namespace src\App;

use src\Routing\Router;

class App
{
    private Router $router;


    public function __construct()
    {
    }

    public function run(): void
    {
        if (array_key_exists('REQUEST_URI', $_SERVER)) {
            $url = substr($_SERVER['REQUEST_URI'], 1);
        } else {
            header("Location: http://localhost:8876/matches");
            exit();
        }
        $this->router = new Router($url);
        $controller = $this->router->getController();

    }
}