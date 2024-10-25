<?php

namespace src\Controllers;

use src\Front\MatchScoreView;

class MatchScoreController extends Controller
{
    public function run(): void
    {
        $matchScoreModel = new MatchScoreModel();
        $matchScoreView = new MatchScoreView();

        $responseCode = 200;
        $data = $matchScoreView->render($matchScoreModel, $responseCode);
        exit();
    }
}