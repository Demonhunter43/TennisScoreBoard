<?php

namespace src\Redis;

use src\DTO\MatchDTO;

class RedisAction
{
    private readonly \Redis $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
    }

    public function getMatchById(int $id): MatchDTO
    {

    }
    public function addMatch(): int
    {

    }
}