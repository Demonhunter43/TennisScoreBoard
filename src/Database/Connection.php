<?php

namespace src\Database;

final class Connection
{
    private static ?self $instance = null;
    private static \PDO $pdoConnection;


    private function __construct()
    {
        require_once "connectionInfo.php";
        /**
         * @var  $hostname ,
         * @var  $dbname ,
         * @var  $port ,
         * @var  $user ,
         * @var  $password
         */
        //self::$pdoConnection = new \PDO("mysql:host=$hostname;dbname=$dbname;port=$port;", $user, $password);
        self::$pdoConnection = new \PDO("pgsql:host=$hostname;port=$port;dbname=$dbname;user=$user;password=$password");
        //$this->pdoConnection = new \PDO('sqlite: tennis.db');
    }

    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return mixed
     */
    public function getPdo(): \PDO
    {
        return self::$pdoConnection;
    }

    public function __clone(): void
    {
    }

    public function __wakeup(): void
    {
    }
}