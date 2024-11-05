<?php

namespace src\View;

use JetBrains\PhpStorm\NoReturn;
use src\Entity\OngoingMatch;

class MatchScoreView
{
    #[NoReturn] public static function render(OngoingMatch $ongoingMatch, int $code): void
    {
        http_response_code($code);
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Tennis score board</title>
        </head>
        <body>
        <section>
            <header>
                <div>
                    <h1>Match number <?= $ongoingMatch->getOngoingId() ?> score board</h1>
                </div>
            </header>
        </section>
        <section>
            <div>
                <table>
                    <thead>
                    <tr>
                        <th>Player Name</th>
                        <th>Game</th>
                        <th>SET1</th>
                        <th>SET2</th>
                        <th>SET3</th>
                        <th>SET4</th>
                        <th>SET5</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </section>
        </body>
        </html>

    <?php }
}