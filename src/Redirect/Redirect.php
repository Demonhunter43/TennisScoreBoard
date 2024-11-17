<?php

namespace src\Redirect;

class Redirect
{
    public static function redirectByLink(string $link): void
    {
        header("Location: $link");
    }

    public static function redirectByPageName(string $pageName): void
    {
        $links = require_once "links.php";
        header($links[$pageName]);
    }
}