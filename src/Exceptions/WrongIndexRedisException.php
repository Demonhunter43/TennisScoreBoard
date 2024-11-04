<?php

namespace src\Exceptions;

class WrongIndexRedisException implements \Throwable
{
    private string $message = "No cashed ongoing match in redis by this index ";

    public function __construct()
    {
    }


    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode()
    {
    }

    public function getFile(): string
    {
        return "asd";
    }

    public function getLine(): int
    {
        return 0;
    }

    public function getTrace(): array
    {
        return [];
    }

    public function getTraceAsString(): string
    {
        return "asd";
    }

    final public function getPrevious(): ?\Exception
    {
        return null;
    }

    public function __toString(): string
    {
        return "asd";
    }
}