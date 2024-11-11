<?php

namespace src\Exceptions;

class DataNotFountInDatabaseException extends \Exception
{
    protected $message = "No data found with this query";
}