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
    #[NoReturn] public function render(?array $data, int $code): void
    {
        http_response_code($code);
        if (is_null($data)) {
            echo "Произошла какая-то ошибка, можно попробовать перезагрузить";
            exit();
        }
        ?>

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
                    foreach ($data as $matchDto) {
                        $matchIndex++; ?>
                        <tr>
                            <th><?= $matchIndex ?></th>
                            <th><?= $matchDto->getPlayer1Name() ?></th>
                            <th><?= $matchDto->getPlayer2Name() ?></th>
                            <th><?= $matchDto->getWinnerName() ?></th>
                        </tr>;
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