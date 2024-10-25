<?php

namespace App\Public;

use App\Controllers\MatchScoreController;
use App\Controllers\NewMatchController;
use App\Controllers\PlayedMatchesController;
use App\Controllers\WrongURLController;

class Router
{
    private string $url;


    public function __construct()
    {
        if (array_key_exists('REQUEST_URI', $_SERVER)) {
            $this->url = substr($_SERVER['REQUEST_URI'], 1);
        } else {
            $this->url = null;
        }
    }

    public function run(): void
    {
        $firstWord = substr($this->url, 0, 7);
        if ($firstWord == "matches") {
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
        $controller = new WrongURLController();
        $controller->run();
    }
}