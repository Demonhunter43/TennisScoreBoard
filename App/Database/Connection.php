<?php

namespace App\Database;

class Connection
{
    private \PDO $pdoConnection;

    public function __construct()
    {
        $this->pdoConnection = new \PDO('sqlite: currency_exchange.db'); //TODO MySQL
    }

    /**
     * @return mixed
     */
    public function getPdo(): \PDO
    {
        return $this->pdoConnection;
    }
}