<?php

namespace src\Redis;

use src\DTO\MatchDTO;
use src\Entity\OngoingMatch;
use src\Exceptions\WrongIndexRedisException;

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

    public function getMatchById(int $id): OngoingMatch
    {
        $this->redis->connect();
        $serializedMatch = $this->redis->get($id);
        if ($serializedMatch === false) {
            throw new WrongIndexRedisException();
        }
        $ongoingMatch = OngoingMatch::deserialize($serializedMatch);
        return $ongoingMatch;
    }

    public function addMatch(OngoingMatch $match): int
    {
        $this->redis->connect();
        $lastIndex = $this->redis->get("lastIndex");

        if ($lastIndex === false) {
            $lastIndex = 0;
            $this->redis->set("lastIndex", $lastIndex);
        } else {
            $lastIndex = (int)$lastIndex;
            $lastIndex++;
            $this->redis->set("lastIndex", $lastIndex);
        }
        $serializedMatch = json_encode($match);
        $this->redis->set($lastIndex, $serializedMatch);
        return $lastIndex;
    }

    public function updateMatch(OngoingMatch $match, int $id): void
    {
        $this->redis->connect();
        $serializedMatch = $this->redis->get($id);
        if ($serializedMatch === false) {
            throw new WrongIndexRedisException();
        }
        $serializedMatch = json_encode($match);
        $this->redis->set($id, $serializedMatch);
    }
}