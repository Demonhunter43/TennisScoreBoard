<?php

namespace src\View;

use JetBrains\PhpStorm\NoReturn;

class ErrorPage
{
    #[NoReturn] public static function render(string $errorMessage, int $code): void
    {
        http_response_code($code);
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Something went wrong</title>
        </head>
        <style>
            .goToFinishedMatches{
                text-align: center;
            }
            h2{
                text-align: center;
            }
        </style>
        <body>
        <section>
            <header>
                <div>
                    <h2><?= $errorMessage ?></h2>
                </div>
            </header>
        </section>
        <div class="goToFinishedMatches">
            <form action="http://localhost:8876/matches">
                <input type="submit" value="go to finished matches"/>
            </form>
        </div>
        </body>
        </html>
        <?php
        die();
    }
}