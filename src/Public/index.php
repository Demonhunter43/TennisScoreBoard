<?php

require_once '../../vendor/autoload.php';

$router = new \src\Public\Router();
$router->run();


header("Location: http://localhost:8876/matches");