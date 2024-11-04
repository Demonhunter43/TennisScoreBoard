<?php

namespace src\Exceptions;

class WrongIndexRedisException extends \Exception
{
    protected $message = "No cashed ongoing match in redis by this index ";
}