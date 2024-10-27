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
            $finishedMatchesView = new FinishedMatchesView();
            $finishedMatchesView->render(null, 500);
        }
        $finishedMatchesView = new FinishedMatchesView();
        $finishedMatchesView->render($arrayOfMatches, 200);
    }
}