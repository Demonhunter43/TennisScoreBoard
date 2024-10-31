<?php

namespace src\Controllers;

use JetBrains\PhpStorm\NoReturn;

class MatchScoreController extends Controller
{
    #[NoReturn] public function run(string $httpMethod, string $uri): void
    {
        $matchScoreModel = new MatchScoreModel();
        $matchScoreView = new MatchScoreView();

        $responseCode = 200;
        $data = $matchScoreView->render($matchScoreModel, $responseCode);
        exit();
    }
}