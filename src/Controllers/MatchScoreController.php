<?php

namespace src\Controllers;

use JetBrains\PhpStorm\NoReturn;
use src\Http\Request;

class MatchScoreController extends Controller
{
    #[NoReturn] public function run(Request $request): void
    {

        echo "We are in Match Score Controller";
        echo "We are in Match Score Controller";
        die();


        $uri = $request->getUri();
        $httpMethod = $request->getMethod();
        $matchScoreModel = new MatchScoreModel();
        $matchScoreView = new MatchScoreView();

        $responseCode = 200;
        $data = $matchScoreView->render($matchScoreModel, $responseCode);
        exit();
    }
}