<?php

namespace src\Redis;

use src\Entity\OngoingMatch;
use src\Exceptions\WrongIndexRedisException;

readonly class RedisAction
{
    private \Redis $redis;
    private string $host;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->host = "redis";
    }


    /**
     * @throws WrongIndexRedisException
     * @throws \RedisException
     */
    public function getMatchById(int $id): OngoingMatch
    {
        $this->redis->connect($this->host);
        $serializedMatch = $this->redis->get($id);
        if ($serializedMatch === false) {
            throw new WrongIndexRedisException();
        }

        return OngoingMatch::deserialize($serializedMatch);
    }

    /**
     * @throws \RedisException
     */
    public function addMatch(OngoingMatch $match): int
    {

        $this->redis->connect($this->host);
        $lastIndex = $this->redis->get("lastIndex");

        if ($lastIndex === false) {
            $lastIndex = 0;
        } else {
            $lastIndex = (int)$lastIndex;
            $lastIndex++;
        }
        $this->redis->set("lastIndex", $lastIndex);

        $match->setOngoingId($lastIndex);
        $serializedMatch = json_encode($match);
        $this->redis->set($lastIndex, $serializedMatch);
        return $lastIndex;
    }


    public function updateMatch(OngoingMatch $match): void
    {
        $id = $match->getOngoingId();
        $serializedMatch = json_encode($match);
        $this->redis->set($id, $serializedMatch);
    }

    public function deleteMatch(OngoingMatch $match): void
    {
        $this->redis->del($match->getOngoingId());
    }
}