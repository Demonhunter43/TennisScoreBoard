<?php

namespace App\Controllers;

use App\Front\MatchScoreView;
use App\Http\HttpResponse;

class MatchScoreController
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