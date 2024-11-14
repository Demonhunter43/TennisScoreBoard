<?php

namespace src\View;

use JetBrains\PhpStorm\NoReturn;
use src\DTO\MatchDTO;

class FinishedMatchesView
{
    /**
     * @param MatchDTO[] $data
     //* @param int $currentPage
     * @param int $code
     * @return void
     */
    #[NoReturn] public static function render(array $data,  int $currentPage, int $code): void
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
            <title>Played matches</title>
            <link rel="stylesheet" type="text/css" href="style.css">
        </head>
        <style>
            th, .matchTd {
                padding: 15px;
                font-size: x-large;
            }

            th {
                background: #3b3939;
                color: white;
            }

            .matchTd {
                background: #ffd165;
                text-align: center;
            }

            .h1 {
                text-align: center;
            }
            .sortingTableTd{
                background: white;
            }
            .sortingTable, .matchesTable{
                margin-left: auto;
                margin-right: auto;
            }

        </style>
        <body>
        <section>
            <header>
                <div class="h1">
                    <h1>Played matches</h1>
                </div>
            </header>
        </section>
        <section>
            <div>
                <table class="sortingTable">
                    <tr class>
                        <td class="sortingTableTd">
                            <form method="get" action="?filter_by_player_name=${NAME}">
                                <label for="playerName"></label>
                                <input class="input-player" placeholder="Name" type="text" id="playerName"
                                       name="filter_by_player_name"
                                       required
                                       pattern="[A-Za-z]+"
                                       minlength="3"
                                       title="Enter a name in the format Name">
                                <input class="form-button" type="submit" value="sort by name">
                            </form>
                        </td>
                        <td class="sortingTableTd">
                            <form method="get" action="">
                                <input class="form-button" type="submit" value="reset">
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </section>
        <section>
            <div>
                <table class="matchesTable">
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
                            <td class="matchTd"><?= $matchDto->getId() ?></td>
                            <td class="matchTd"><?= $matchDto->getPlayer1Name() ?></td>
                            <td class="matchTd"><?= $matchDto->getPlayer2Name() ?></td>
                            <td class="matchTd"><?= $matchDto->getWinnerName() ?></td>
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