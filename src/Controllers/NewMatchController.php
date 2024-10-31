<?php

namespace src\Controllers;

class NewMatchController extends Controller
{
    public function run(string $httpMethod, string $uri): void
    {
        if ($httpMethod == "GET") {
            $this->runGet();
        }
        if ($httpMethod == "Post") {
            $this->runPost($uri);
        }
    }

    public function runGet(): void
    {

    }

    public function runPost(string $uri): void
    {

    }
}