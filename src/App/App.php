<?php

namespace src\App;

use JetBrains\PhpStorm\NoReturn;
use src\Http\Request;
use src\Routing\Router;

class App
{
    #[NoReturn] public static function run(): void
    {
        $request = new Request();
        $controller = Router::getController($request);
        $controller->run($request);
    }
}