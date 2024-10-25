<?php

namespace App\Controllers;

class WrongURLController
{
    public function run (): void
    {
        require_once "../View/redirectPage.php";
        sleep(5);
        header("Location: http://localhost:63342/TennisScoreBoard/matches");
    }
}