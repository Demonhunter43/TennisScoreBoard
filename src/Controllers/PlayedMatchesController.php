<?php

namespace src\Controllers;

use JetBrains\PhpStorm\NoReturn;
use src\Database\DatabaseAction;
use src\Http\Request;
use src\View\ErrorPage;
use src\View\FinishedMatchesView;

define("DEFAULT_PAGE", 1);

class PlayedMatchesController extends Controller
{
    private DatabaseAction $databaseAction;

    public function __construct()
    {
        try {
            $this->databaseAction = new DatabaseAction();
        } catch (\Exception $e) {
            ErrorPage::render($e->getMessage(), 500);
        }
    }

    public function run(Request $request): void
    {
        $query = parse_url($request->getUri(), PHP_URL_QUERY);

        $page = DEFAULT_PAGE;
        if (!empty($query)) {
            parse_str($query, $queryArray);
            if (array_key_exists("page", $queryArray)) {
                $page = $queryArray["page"];
            }
        } else {
            $this->showAllMatches($page);
        }
        if (array_key_exists("filter_by_player_name", $queryArray)) {
            $this->showMatchesByPlayerName($queryArray["filter_by_player_name"], $page);
        } else {
            ErrorPage::render("Wrong query", 500);
        }

    }

    public function showMatchesByPlayerName(string $playerName, int $page): void
    {
        try {
            $arrayOfMatches = $this->databaseAction->getMatchesByPlayerName($playerName);
        } catch (\Exception $e) {
            ErrorPage::render($e->getMessage(), 500);
        }
        FinishedMatchesView::render($arrayOfMatches, $page, 200);
    }

    #[NoReturn] public function showAllMatches(int $page): void
    {
        try {
            $arrayOfMatches = $this->databaseAction->getAllMatches();
        } catch (\Exception $e) {
            ErrorPage::render($e->getMessage(), 500);
        }
        FinishedMatchesView::render($arrayOfMatches, $page, 200);
    }
}