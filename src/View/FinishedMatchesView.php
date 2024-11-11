<?php

namespace src\View;

use JetBrains\PhpStorm\NoReturn;
use src\DTO\MatchDTO;

class FinishedMatchesView
{
    /**
     * @param MatchDTO[] $data
     * @param int $code
     * @return void
     */
    #[NoReturn] public static function render(array $data, int $code): void
    {
        http_response_code($code);
        ?>

        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Played matches</title>
        </head>
        <body>
        <section>
            <header>
                <div>
                    <h1>Played matches</h1>
                </div>
            </header>
        </section>
        <section>
            <div>
                <form method="get" action="?filter_by_player_name=${NAME}">
                    <label for="playerName"></label>
                    <input class="input-player" placeholder="Name" type="text" id="playerName"
                           name="filter_by_player_name"
                           required
                           pattern="[A-Za-z]+"
                           minlength="3"
                           title="Enter a name in the format Name">
                    <input class="form-button" type="submit" value="Sort by name">
                </form>
            </div>
        </section>
        <section>
            <div>
                <table>
                    <thead>
                    <tr>
                        <th>Match id</th>
                        <th>Player 1</th>
                        <th>Player 2</th>
                        <th>Winner</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ($data as $matchDto) {
                        ?>
                        <tr>
                            <th><?= $matchDto->getId() ?></th>
                            <th><?= $matchDto->getPlayer1Name() ?></th>
                            <th><?= $matchDto->getPlayer2Name() ?></th>
                            <th><?= $matchDto->getWinnerName() ?></th>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
        </body>
        </html>

        <?php
        exit();
    }
}