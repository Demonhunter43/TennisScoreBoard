<?php

namespace src\Controllers;

use JetBrains\PhpStorm\NoReturn;
use src\Http\Request;
use src\Redis\RedisAction;

class MatchScoreController extends Controller
{
    #[NoReturn] public function run(Request $request): void
    {
        $
        $ongoingMatchId = $request->getUri();
        $redis = new RedisAction();
        $ongoingMatch = $redis->getMatchById(0);
        var_dump($ongoingMatch);
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