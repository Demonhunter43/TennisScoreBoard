<?php

namespace src\Controllers;

use src\Database\DatabaseAction;
use src\DTO\PlayerDTO;
use src\View\ErrorPage;
use src\View\NewMatchPage;

class NewMatchController extends Controller
{
    public function run(string $uri, string $httpMethod): void
    {
        if ($httpMethod == "GET") {
            $this->runGet();
        }
        if ($httpMethod == "POST") {
            $this->runPost($uri);
        }
    }

    public function runGet(): void
    {
        NewMatchPage::render(null, 200);
    }

    public function runPost(string $uri): void
    {
        $playerOneDTO = new PlayerDTO(null, $_POST["playerOneName"]);
        $playerTwoDTO = new PlayerDTO(null, $_POST["playerTwoName"]);
        $databaseAction = new DatabaseAction();

        // Checking are players presented in DB
        if (!$databaseAction->isPlayerPresentedInDatabase($playerOneDTO)) {
            try {
                $databaseAction->addPlayer($playerOneDTO);
            } catch (\Exception $e) {
                ErrorPage::render($e->getMessage(), 500);
                return;
            }
        }
        if (!$databaseAction->isPlayerPresentedInDatabase($playerTwoDTO)) {
            $databaseAction->addPlayer($playerTwoDTO);
        }

    }
}