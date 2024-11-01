<?php

namespace src\Controllers;

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
        NewMatchPage::render();
    }

    public function runPost(string $uri): void
    {

    }
}