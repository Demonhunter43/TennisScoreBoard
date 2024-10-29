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
         * @var  $login ,
         * @var  $password
         */
        self::$pdoConnection = new \PDO("mysql:host=$hostname;dbname=$dbname;port=$port;",$login,$password);
        //$this->pdoConnection = new \PDO('sqlite: tennis.db');
    }
    public static function getInstance(): self
    {
        if (is_null(self::$instance)){
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
        // TODO: Implement __clone() method.
    }

    public function __wakeup(): void
    {
        // TODO: Implement __wakeup() method.
    }
}