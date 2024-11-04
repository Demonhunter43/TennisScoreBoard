<?php

namespace src\Entity;

class Score implements \JsonSerializable
{
    private int $firstPlayerScore;
    private int $secondPlayerScore;

    /**
     * @param int $firstPlayerScore
     * @param int $secondPlayerScore
     */
    public function __construct(int $firstPlayerScore, int $secondPlayerScore)
    {
        $this->firstPlayerScore = $firstPlayerScore;
        $this->secondPlayerScore = $secondPlayerScore;
    }

    public function getHighestScore(): int
    {
        return max($this->firstPlayerScore, $this->secondPlayerScore);
    }

    public function getDifference(): int
    {
        return abs($this->firstPlayerScore - $this->secondPlayerScore);
    }

    public function getFirstPlayerScore(): int
    {
        return $this->firstPlayerScore;
    }

    public function setFirstPlayerScore(int $firstPlayerScore): void
    {
        $this->firstPlayerScore = $firstPlayerScore;
    }

    public function getSecondPlayerScore(): int
    {
        return $this->secondPlayerScore;
    }

    public function setSecondPlayerScore(int $secondPlayerScore): void
    {
        $this->secondPlayerScore = $secondPlayerScore;
    }

    public function jsonSerialize(): array
    {
        return [
            'firstPlayerScore' => $this->firstPlayerScore,
            'secondPlayerScore' => $this->secondPlayerScore
        ];
    }

    public static function deserialize(array $arrayScore): self
    {
        return new Score($arrayScore["firstPlayerScore"], $arrayScore["secondPlayerScore"]);
    }
}