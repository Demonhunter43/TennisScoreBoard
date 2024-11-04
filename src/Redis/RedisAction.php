<?php

namespace src\Redis;

use src\DTO\MatchDTO;

class RedisAction
{
    private readonly \Redis $redis;
    private int $index;

    public function __construct()
    {
        $this->redis = new \Redis([
            'host' => "redis",
            'port' => 6379
        ]);
    }

    public function getMatchById(int $id): MatchDTO
    {

    }

    public function addMatch(): int
    {
        asd
    }
}