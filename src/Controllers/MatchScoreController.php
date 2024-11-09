<?php

namespace src\Controllers;

use Exception;
use JetBrains\PhpStorm\NoReturn;
use src\Http\Request;
use src\Redis\RedisAction;
use src\Services\FinishedMatchesPersistenceService;
use src\Services\MatchScoreCalculationService;
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
        $ongoingMatchId = $this->getCheckedUuid($request);

        try {
            $ongoingMatch = $this->redisAction->getMatchById($ongoingMatchId);
        } catch (Exception $e) {
            ErrorPage::render($e->getMessage(), 400);
        }
        MatchScoreView::render($ongoingMatch, 200);
    }

    private function runPost(Request $request): void
    {
        $ongoingMatchId = $this->getCheckedUuid($request);
        $serveWinnerID = $request->getPostData()["serveWinnerID"];

        try {
            $ongoingMatch = $this->redisAction->getMatchById($ongoingMatchId);
        } catch (Exception $e) {
            ErrorPage::render($e->getMessage(), 400);
        }
        $ongoingMatch = MatchScoreCalculationService::calculate($ongoingMatch, $serveWinnerID);
        if (is_null($ongoingMatch->getWinner())) {
            $this->redisAction->updateMatch($ongoingMatch);
        } else {
            $this->redisAction->deleteMatchById($ongoingMatch->getOngoingId());
            FinishedMatchesPersistenceService::saveFinishedMatch($ongoingMatch);
        }
        MatchScoreView::render($ongoingMatch, 200);
    }

    private function getCheckedUuid(Request $request): int
    {
        parse_str(parse_url($request->getUri(), PHP_URL_QUERY), $queryArray);
        if (!array_key_exists("uuid", $queryArray)) {
            ErrorPage::render("Wrong query", 422);
        }
        return (int)$queryArray["uuid"];
    }
}