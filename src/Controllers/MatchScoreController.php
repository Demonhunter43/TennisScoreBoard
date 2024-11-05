<?php

namespace src\Controllers;

use JetBrains\PhpStorm\NoReturn;
use src\Http\Request;
use src\Redis\RedisAction;
use src\View\ErrorPage;
use src\View\MatchScoreView;

class MatchScoreController extends Controller
{
    private RedisAction $redisAction;


    public function __construct()
    {
        $this->redisAction = new RedisAction();
    }


    #[NoReturn] public function run(Request $request): void
    {
        $httpMethod = $request->getMethod();

        if ($httpMethod == "GET") {
            $this->runGet($request);
        }
        if ($httpMethod == "POST") {
            $this->runPost($request);
        }
    }

    public function runGet(Request $request): void
    {
        parse_str(parse_url($request->getUri(), PHP_URL_QUERY), $queryArray);
        if (!array_key_exists("uuid", $queryArray)) {
            ErrorPage::render("Wrong query", 422);
        }
        $ongoingMatchId = (int)$queryArray["uuid"];

        try {
            $ongoingMatch = $this->redisAction->getMatchById($ongoingMatchId);
        } catch (\Exception $e) {
            ErrorPage::render($e->getMessage(), 400);
        }
        MatchScoreView::render($ongoingMatch, 200);
        //var_dump($ongoingMatch);
    }

    private function runPost(Request $request)
    {

        MatchScoreView::render($ongoingMatch, 200);
    }
}