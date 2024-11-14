<?php

namespace src\Exceptions;

class WrongIndexRedisException extends \Exception
{
    protected $message = "This match hasn't started or already finished";
}