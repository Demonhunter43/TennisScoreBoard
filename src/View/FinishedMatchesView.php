<?php

namespace src\View;

use JetBrains\PhpStorm\NoReturn;
use src\DTO\MatchDTO;

class FinishedMatchesView
{


    /**
     * @param array $data
     * @param int $currentPage
     * @param int $maxPage
     * @param int $code
     * @param string|null $filteredPlayerName
     * @return void
     */
    #[NoReturn] public static function render(array   $data,
                                              int     $currentPage,
                                              int     $maxPage,
                                              int     $code,
                                              ?string $filteredPlayerName = null): void
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

            .sortingTableTd {
                background: white;
            }

            .sortingTable, .matchesTable {
                margin-left: auto;
                margin-right: auto;
            }

            .pageSwitch {
                margin-left: auto;
                margin-right: auto;
            }

            .startNewMatchButton {
                text-align: center;
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
                            <form method="get" action="">
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
                        if (is_null($matchDto)) continue;
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
        <section>
            <table class="pageSwitch">
                <tr>
                    <?php
                    if ($currentPage > 1) { ?>
                        <td>
                            <form action="">
                                <?php if (!is_null($filteredPlayerName)) { ?>
                                    <input type="hidden"
                                           name="filter_by_player_name"
                                           value="<?= $filteredPlayerName ?>">
                                <?php } ?>
                                <input type="hidden"
                                       name="page"
                                       value="<?= $currentPage - 1 ?>">
                                <input type="submit" value="<"/>
                            </form>
                        </td>
                    <?php }
                    for ($i = 1; $i <= $maxPage; $i++) {
                        if ($i == $currentPage) { ?>
                            <td>
                                <b><?= $i ?></b>
                            </td>
                        <?php } else { ?>
                            <td>
                                <form action="">
                                    <?php if (!is_null($filteredPlayerName)) { ?>
                                        <input type="hidden"
                                               name="filter_by_player_name"
                                               value="<?= $filteredPlayerName ?>">
                                    <?php } ?>
                                    <input type="hidden"
                                           name="page"
                                           value="<?= $i ?>">
                                    <input type="submit" value="<?= $i ?>"/>
                                </form>
                            </td>
                            <?php
                        }
                    }
                    if ($currentPage < $maxPage) {
                        ?>
                        <td>
                            <form action="">
                                <?php if (!is_null($filteredPlayerName)) { ?>
                                    <input type="hidden"
                                           name="filter_by_player_name"
                                           value="<?= $filteredPlayerName ?>">
                                <?php } ?>
                                <input type="hidden"
                                       name="page"
                                       value="<?= $currentPage + 1 ?>">
                                <input type="submit" value=">"/>
                            </form>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
            </table>
            <div class="startNewMatchButton">
                <form action="http://localhost:8876/new-match">
                    <input type="submit" value="Start new match"/>
                </form>
            </div>
        </section>
        </body>
        </html>

        <?php
        exit();
    }
}