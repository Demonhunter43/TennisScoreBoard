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
        <body>
        <section>
            <header>
                <div>
                    <h2><?= $errorMessage ?></h2>
                </div>
            </header>
        </section>
        </body>
        </html>
        <?php
    }
}