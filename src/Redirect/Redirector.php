<?php

namespace src\Redirect;

class Redirector
{
    public static function redirectByLink(string $link): void
    {
        header("Location: $link");
    }

    public static function redirectByPageName(string $pageName)
    {
        header($link);
    }
}