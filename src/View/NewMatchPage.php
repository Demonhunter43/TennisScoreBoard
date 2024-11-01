<?php

namespace src\View;

class NewMatchPage
{
    public static function render(): void
    { ?>
        <!doctype html>
        <html lang="en">
        <head>
            <title>New match</title>
        </head>
        <body>
        <section>
            <header>
                <div>
                    <h1>Make new match</h1>
                </div>
            </header>
        </section>
        <section>
            <form method="post" action="#">
                <label class="label-player" for="playerOne">Player one</label>
                <input class="input-player" placeholder="Name" type="text" id="playerOne"
                       name="playerOne"
                       required
                       pattern="[A-Za-z]"
                       minlength="3"
                       title="Enter a name in the format <Name>">
                <label class="label-player" for="playerTwo">Player two</label>
                <input class="input-player" placeholder="Name" type="text" id="playerTwo"
                       name="playerTwo"
                       required
                       pattern="[A-Za-z]"
                       minlength="3"
                       title="Enter a name in the format <Name>">
                <input class="form-button" type="submit" value="Start">
            </form>
        </section>
        </body>
        </html>

        <?php
    }
}