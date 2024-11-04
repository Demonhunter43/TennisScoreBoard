<?php

namespace src\Controllers;

use JetBrains\PhpStorm\NoReturn;
use src\Exceptions\WrongIndexRedisException;
use src\Http\Request;
use src\Redis\RedisAction;

class MatchScoreController extends Controller
{
    #[NoReturn] public function run(Request $request): void
    {
        $query = parse_url($request->getUri(), PHP_URL_QUERY);
        parse_str($query, $ongoingMatchId);
        $ongoingMatchId = (int)$ongoingMatchId["uuid"];

        $redis = new RedisAction();
        try {
            $ongoingMatch = $redis->getMatchById($ongoingMatchId);
        } catch (\Exception $e){
            var_dump($e->getMessage());
            exit();
        }
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