<?php

namespace src\App;

use src\Http\Request;
use src\Routing\Router;

class App
{
    public static function run(): void
    {
        $request = new Request();
        $controller = Router::getController($request->getMethod());
        $controller->run();
    }
}