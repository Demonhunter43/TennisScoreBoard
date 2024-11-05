<?php

namespace src\Controllers;

use src\Database\DatabaseAction;
use src\DTO\PlayerDTO;
use src\Entity\OngoingMatch;
use src\Entity\Player;
use src\Entity\Score;
use src\Http\Request;
use src\Redis\RedisAction;
use src\View\ErrorPage;
use src\View\NewMatchPage;

class NewMatchController extends Controller
{
    public function run(Request $request): void
    {
        $httpMethod = $request->getMethod();

        if ($httpMethod == "GET") {
            $this->runGet();
        }
        if ($httpMethod == "POST") {
            $this->runPost($request->getPostData());
        }
    }

    public function runGet(): void
    {
        NewMatchPage::render(200);
    }

    public function runPost(array $postData): void
    {
        $playerOneDTO = new PlayerDTO(null, $postData["playerOneName"]);
        $playerTwoDTO = new PlayerDTO(null, $postData["playerTwoName"]);
        $databaseAction = null;
        try {
            $databaseAction = new DatabaseAction();
        } catch (\Exception $e) {
            ErrorPage::render($e->getMessage(), 500);
        }

        try {
            $playerOneDTO = $databaseAction->getPlayerByName($playerOneDTO->getName());
        } catch (\Exception $e) {
            try {
                $playerOneDTO = $databaseAction->addPlayer($playerOneDTO);
            } catch (\Exception $e) {
                ErrorPage::render($e->getMessage(), 500);
            }
        }

        try {
            $playerTwoDTO = $databaseAction->getPlayerByName($playerTwoDTO->getName());
        } catch (\Exception $e) {
            try {
                $playerTwoDTO = $databaseAction->addPlayer($playerTwoDTO);
            } catch (\Exception $e) {
                ErrorPage::render($e->getMessage(), 500);
            }
        }

        $player1 = new Player($playerOneDTO->getId(), $playerOneDTO->getName());
        $player2 = new Player($playerTwoDTO->getId(), $playerTwoDTO->getName());
        $redisAction = new RedisAction();

        $newOngoingMatch = new OngoingMatch(null, $player1, $player2);
        try {
            $newMatchId = $redisAction->addMatch($newOngoingMatch);
            $newOngoingMatch->setOngoingId($newMatchId);
            $redisAction->updateMatch($newOngoingMatch);
        } catch (\Exception $e) {
            ErrorPage::render($e->getMessage(), 400);
        }
        // Redirect
        header("Location: http://localhost:8876/match-score?uuid={$newMatchId}");
    }
}