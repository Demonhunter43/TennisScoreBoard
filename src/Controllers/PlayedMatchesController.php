<?php

namespace src\Controllers;

use JetBrains\PhpStorm\NoReturn;
use src\Database\DatabaseAction;
use src\Http\Request;
use src\View\ErrorPage;
use src\View\FinishedMatchesView;

define("DEFAULT_PAGE", 1);
define("NUMBER_OF_MATCHES_ON_PAGE", 4);

class PlayedMatchesController extends Controller
{
    private DatabaseAction $databaseAction;
    private int $currentPage;

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

        $this->currentPage = DEFAULT_PAGE;
        if (!empty($query)) {
            parse_str($query, $queryArray);
            if (array_key_exists("page", $queryArray)) {
                $this->currentPage = $queryArray["page"];
            }
        } else {
            $this->showAllMatches();
        }
        if (array_key_exists("filter_by_player_name", $queryArray)) {
            $this->showMatchesByPlayerName($queryArray["filter_by_player_name"]);
        } else {
            ErrorPage::render("Wrong query", 500);
        }
    }

    public function showMatchesByPlayerName(string $playerName): void
    {
        try {
            $arrayOfMatches = $this->databaseAction->getMatchesByPlayerName($playerName);
        } catch (\Exception $e) {
            ErrorPage::render($e->getMessage(), 500);
        }
        $maxPage = count($arrayOfMatches);
        if ($this->currentPage > $maxPage) {

        }
        FinishedMatchesView::render($arrayOfMatches, $this->currentPage, $maxPage, 200);
    }

    #[NoReturn] public function showAllMatches(): void
    {
        try {
            $arrayOfMatches = $this->databaseAction->getAllMatches();
        } catch (\Exception $e) {
            ErrorPage::render($e->getMessage(), 500);
        }
        $maxPage = count($arrayOfMatches);
        //TODO sort $arrayOfMatches according page number
        FinishedMatchesView::render($arrayOfMatches, $this->currentPage, $maxPage, 200);
    }
}