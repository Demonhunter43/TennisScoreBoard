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
        <style>
            th, td {
                padding: 15px;
                font-size: x-large;
            }

            th {
                background: #3b3939;
                color: white;
            }

            td {
                background: #ffd165;
                text-align: center;
            }

            h1 {
                padding-left: 250px;
            }
        </style>
        <body>
        <section>
            <header>
                <div>
                    <h1>Score board match <?= $ongoingMatch->getOngoingId() ?></h1>
                </div>
            </header>
        </section>
        <?php
        if (!is_null($ongoingMatch->getWinner())) {
            ?>
            <section>
                <div>
                    <h2> This match finished. Results added to Database.</h2>
                    <h2> Winner: <?= $ongoingMatch->getWinner()->getName(); ?></h2>
                    <h2> Final score board:</h2>
                </div>
            </section>
            <?php
        }
        ?>
        <section>
            <div>
                <table>
                    <thead>
                    <tr>
                        <th>Player Name</th>
                        <?php
                        for ($i = 1; $i <= $ongoingMatch->getNumberOfSets(); $i++) {
                            ?>
                            <th>SET<?= $i ?></th>
                            <?php
                        }
                        if (is_null($ongoingMatch->getWinner())) {
                            ?>
                            <th>GAME</th>
                        <?php } else { ?>
                            <th>GAMES</th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?= $ongoingMatch->getPlayer1()->getName() ?></td>
                        <?php
                        $gamesInSets = $ongoingMatch->getGamesInSets();
                        foreach ($gamesInSets as $gameInSet) {
                            ?>
                            <td><?= $gameInSet->getFirstPlayerScore(); ?></td>
                        <?php }
                        if (is_null($ongoingMatch->getWinner())) {
                            ?>
                            <td><?= $ongoingMatch->getPoints()->getFirstPlayerScore(); ?></td>
                            <td>
                                <form method="post" action="#">
                                    <label class="label-player" for="serveWinner"></label>
                                    <input class="input-player" id="serveWinner"
                                           hidden="hidden"
                                           name="serveWinnerID"
                                           value="<?= $ongoingMatch->getPlayer1()->getId() ?>">
                                    <input class="form-button" type="submit" value="Wins this serve!">
                                </form>
                            </td>
                        <?php } else {
                            $sumGamesPlayer1 = 0;
                            $sumGamesPlayer2 = 0;
                            for ($i = 0; $i < $ongoingMatch->getNumberOfSets(); $i++) {
                                $sumGamesPlayer1 = $sumGamesPlayer1 + $gamesInSets[$i]->getFirstPlayerScore();
                                $sumGamesPlayer2 = $sumGamesPlayer2 + $gamesInSets[$i]->getSecondPlayerScore();
                            }
                            ?>
                            <td><?= $sumGamesPlayer1; ?></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td><?= $ongoingMatch->getPlayer2()->getName() ?></td>
                        <?php
                        $gamesInSets = $ongoingMatch->getGamesInSets();
                        foreach ($gamesInSets as $gameInSet) {
                            ?>
                            <td><?= $gameInSet->getSecondPlayerScore(); ?></td>
                        <?php }
                        if (is_null($ongoingMatch->getWinner())) {
                            ?>
                            <td><?= $ongoingMatch->getPoints()->getSecondPlayerScore(); ?></td>
                            <td>
                                <form method="post" action="#">
                                    <label class="label-player" for="serveWinner"></label>
                                    <input class="input-player" id="serveWinner"
                                           hidden="hidden"
                                           name="serveWinnerID"
                                           value="<?= $ongoingMatch->getPlayer2()->getId() ?>">
                                    <input class="form-button" type="submit" value="Wins this serve!">
                                </form>
                            </td>
                            <?php
                        } else { ?>
                            <td><?= $sumGamesPlayer2; ?></td>
                        <?php } ?>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>
        </body>
        </html>

    <?php }
}