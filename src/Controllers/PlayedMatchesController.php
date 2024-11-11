<?php

namespace src\Controllers;

use src\Database\DatabaseAction;
use src\Http\Request;
use src\View\ErrorPage;
use src\View\FinishedMatchesView;

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

        if (!empty($query)) {
            parse_str($query, $queryArray);
            if (array_key_exists("filter_by_player_name", $queryArray)) {
                $this->showMatchesByPlayerName($queryArray["filter_by_player_name"]);
            } else {
                ErrorPage::render("Wrong query", 500);
            }
        } else {
            $this->showAllMatches();
        }
    }

    public function showMatchesByPlayerName(string $playerName): void
    {
        try {
            $arrayOfMatches = $this->databaseAction->getMatchesByPlayerName($playerName);
        } catch (\Exception $e) {
            ErrorPage::render($e->getMessage(), 500);
        }
        FinishedMatchesView::render($arrayOfMatches, 200);
    }

    public function showAllMatches(): void
    {
        try {
            $arrayOfMatches = $this->databaseAction->getAllMatches();
        } catch (\Exception $e) {
            ErrorPage::render($e->getMessage(), 500);
        }
        FinishedMatchesView::render($arrayOfMatches, 200);
    }
}