<?php

namespace App\Database;

class Connection
{
    private \PDO $pdoConnection;

    public function __construct()
    {
        require_once "connectionInfo.php";
        /**
         * @var  $hostname ,
         * @var  $dbname ,
         * @var  $port ,
         * @var  $login ,
         * @var  $password
         */

        $this->pdoConnection = new \PDO("mysql:host=$hostname;dbname=$dbname;port=$port;",$login,$password);
        //$this->pdoConnection = new \PDO('sqlite: tennis.db');
    }

    /**
     * @return mixed
     */
    public function getPdo(): \PDO
    {
        return $this->pdoConnection;
    }
}