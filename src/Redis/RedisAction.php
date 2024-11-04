<?php

namespace src\Redis;

use src\DTO\MatchDTO;
use src\Entity\OngoingMatch;

class RedisAction
{
    private readonly \Redis $redis;

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

    public function addMatch(OngoingMatch $match): int
    {
        $this->redis->connect();
        $lastIndex = (int)$this->redis->get("lastIndex");

        if ($lastIndex == 0) {
            $this->redis->set("lastIndex", $lastIndex);
        } else {
            $lastIndex++;
            $this->redis->set("lastIndex", $lastIndex);
        }
        $serializedMatch = json_encode($match);
        $this->redis->set($lastIndex, $serializedMatch);
        return $lastIndex;
    }

    public function updateMatch(OngoingMatch $match, int $index): void
    {

    }
}