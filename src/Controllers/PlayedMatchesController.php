<?php

namespace src\Controllers;

use src\Database\DatabaseAction;
use src\View\ErrorPage;
use src\View\FinishedMatchesView;

class PlayedMatchesController extends Controller
{
    public function run(string $httpMethod, string $uri): void
    {
        $databaseAction = new DatabaseAction();
        try {
            $arrayOfMatches = $databaseAction->getAllMatches();
        } catch (\Exception $e) {
            ErrorPage::render($e->getMessage(), 500);
            return;
        }
        FinishedMatchesView::render($arrayOfMatches, 200);
    }
}