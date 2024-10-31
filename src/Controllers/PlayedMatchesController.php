<?php

namespace src\Controllers;

use src\Database\DatabaseAction;
use src\View\FinishedMatchesView;

class PlayedMatchesController extends Controller
{
    public function run(): void
    {
        $dbAction = new DatabaseAction();
        try {
            $arrayOfMatches = $dbAction->getAllMatches();
        } catch (\Exception $e){
            var_dump($e->getMessage());
            FinishedMatchesView::render(null, 500);
        }
        FinishedMatchesView::render($arrayOfMatches, 200);
    }
}