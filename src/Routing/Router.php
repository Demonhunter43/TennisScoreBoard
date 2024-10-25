<?php

namespace src\Routing;

use src\Controllers\MatchScoreController;
use src\Controllers\NewMatchController;
use src\Controllers\PlayedMatchesController;

class Router
{
    private string $url;


    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getController():
    {
        $firstWord = substr($this->url, 0, 7);
        if ($firstWord == "matches") {
            var_dump("Это страница матчей");
            $controller = new PlayedMatchesController($this->url);
            $controller->run();
        }
        $firstWord = substr($this->url, 0, 9);
        if ($firstWord == "new-match") {
            $controller = new NewMatchController($this->url);
            $controller->run();
        }
        $firstWord = substr($this->url, 0, 11);
        if ($firstWord == "match-score") {
            $controller = new MatchScoreController($this->url);
            $controller->run();
        }
        header("Location: http://localhost:8876/matches");
    }
}