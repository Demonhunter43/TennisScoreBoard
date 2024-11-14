<?php

namespace src\Controllers;

use JetBrains\PhpStorm\NoReturn;
use src\Database\DatabaseAction;
use src\Http\Request;
use src\Redirect\Redirector;
use src\View\ErrorPage;
use src\View\FinishedMatchesView;

define("DEFAULT_PAGE", 1);
define("NUMBER_OF_MATCHES_ON_PAGE", 5);

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

    private function showMatchesByPlayerName(string $playerName): void
    {
        try {
            $arrayOfMatches = $this->databaseAction->getMatchesByPlayerName($playerName);
        } catch (\Exception $e) {
            ErrorPage::render($e->getMessage(), 500);
        }
        $maxPage = (int)ceil(count($arrayOfMatches) / NUMBER_OF_MATCHES_ON_PAGE);
        if ($this->currentPage > $maxPage) {
            Redirector::redirectByPageName("matches");
        }
        $arrayOfMatches = $this->cutArrayAccordingCurrentPage($arrayOfMatches);
        FinishedMatchesView::render($arrayOfMatches, $this->currentPage, $maxPage, 200);
    }

    #[NoReturn] private function showAllMatches(): void
    {
        try {
            $arrayOfMatches = $this->databaseAction->getAllMatches();
        } catch (\Exception $e) {
            ErrorPage::render($e->getMessage(), 500);
        }
        $maxPage = (int)ceil(count($arrayOfMatches) / NUMBER_OF_MATCHES_ON_PAGE);
        if ($this->currentPage > $maxPage) {
            Redirector::redirectByPageName("matches");
        }
        $arrayOfMatches = $this->cutArrayAccordingCurrentPage($arrayOfMatches);
        FinishedMatchesView::render($arrayOfMatches, $this->currentPage, $maxPage, 200);
    }

    private function cutArrayAccordingCurrentPage(array $arrayOfMatches): array
    {
        $leftIndex = ($this->currentPage - 1) * NUMBER_OF_MATCHES_ON_PAGE;
        $rightIndex = $this->currentPage * NUMBER_OF_MATCHES_ON_PAGE;
        $dataArray = null;
        for ($i = $leftIndex; $i < $rightIndex; $i++) {
            if (array_key_exists($i, $arrayOfMatches)) {
                $dataArray[$i] = $arrayOfMatches[$i];
            } else {
                $dataArray[$i] = null;
            }
        }
        return $dataArray;
    }
}