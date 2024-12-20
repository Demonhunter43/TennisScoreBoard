<?php

namespace src\View;

class NewMatchPage
{
    public static function render(int $code): void
    {
        http_response_code($code);
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <title>New match</title>
        </head>
        <style>
            .formSection {
                text-align: center;
            }

            h1 {
                text-align: center;
            }
        </style>
        <body>
        <section>
            <header>
                <div>
                    <h1>Make new match</h1>
                </div>
            </header>
        </section>
        <section class="formSection">
            <form method="post" action="#">
                <label class="label-player" for="playerOneName">Player one</label>
                <input class="input-player" placeholder="Name" type="text" id="playerOneName"
                       name="playerOneName"
                       required
                       pattern="[A-Za-z]+"
                       minlength="3"
                       title="Enter a name in the format Name">
                <label class="label-player" for="playerTwoName">Player two</label>
                <input class="input-player" placeholder="Name" type="text" id="playerTwoName"
                       name="playerTwoName"
                       required
                       pattern="[A-Za-z]+"
                       minlength="3"
                       title="Enter a name in the format Name">
                <label class="label-player" for="numberOfSets">Sets number (3 or 5)</label>
                <input class="input-player" type="number" id="numberOfSets"
                       pattern="[0-9]{1}"
                       name="numberOfSets">
                <input class="form-button" type="submit" value="Start">
            </form>
        </section>
        </body>
        </html>

        <?php
    }
}