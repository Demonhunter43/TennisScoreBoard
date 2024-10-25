<?php

namespace src\App;

use src\Routing\Router;

class App
{
    private Router $router;


    public function __construct()
    {
        $this->router = new Router();
    }

    public function run()
    {

    }
}