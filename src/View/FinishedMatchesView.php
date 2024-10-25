<?php

namespace src\View;

class FinishedMatchesView
{
    public function render(array $data, int $code): void
    { ?>

        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Сыгранные матчи</title>
        </head>
        <body>
        <section>
            <header>
                <div>
                    <h1>Сыгранные матчи</h1>
                </div>
            </header>
        </section>
        <section>
            <div>
                <table>
                    <thead>
                    <tr>
                        <th>ID матча</th>
                        <th>Игрок 1</th>
                        <th>Игрок 2</th>
                        <th>Победитель</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $matchIndex = 0;
                    foreach ($data as $match) {
                        $matchIndex++; ?>
                        <tr>
                            <th><?= $matchIndex ?></th>
                            <th><?= $match["player1"] ?></th>
                            <th><?= $match["player2"] ?></th>
                            <th><?= $match["winner"] ?></th>
                        </tr>;
                    <?php } ?>

                    </tbody>
                </table>
            </div>
        </section>
        </body>
        </html>


        <?php
    }
}