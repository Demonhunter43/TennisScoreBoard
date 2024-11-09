<?php

namespace src\Entity;

class Score implements \JsonSerializable
{
    private mixed $firstPlayerScore;
    private mixed $secondPlayerScore;

    /**
     * @param int $firstPlayerScore
     * @param int $secondPlayerScore
     */
    public function __construct(mixed $firstPlayerScore, mixed $secondPlayerScore)
    {
        $this->firstPlayerScore = $firstPlayerScore;
        $this->secondPlayerScore = $secondPlayerScore;
    }

    public function getHighestScore(): int
    {
        return max($this->firstPlayerScore, $this->secondPlayerScore);
    }

    public function isAllowedDifference(): bool
    {
        return abs($this->firstPlayerScore - $this->secondPlayerScore) >= 2;
    }

    public function getDifference(): int
    {
        return abs($this->firstPlayerScore - $this->secondPlayerScore);
    }

    public function getFirstPlayerScore(): mixed
    {
        return $this->firstPlayerScore;
    }

    public function setFirstPlayerScore(mixed $firstPlayerScore): void
    {
        $this->firstPlayerScore = $firstPlayerScore;
    }

    public function getSecondPlayerScore(): mixed
    {
        return $this->secondPlayerScore;
    }

    public function getPlayerScoreByInMatchId(int $inMatchId): mixed
    {
        if ($inMatchId == 1) {
            return $this->firstPlayerScore;
        } else {
            return $this->secondPlayerScore;
        }
    }

    public function setPlayerScoreByInMatchId(mixed $newScore, int $inMatchId): void
    {
        if ($inMatchId == 1) {
            $this->firstPlayerScore = $newScore;
        } else {
            $this->secondPlayerScore = $newScore;
        }
    }

    public function setSecondPlayerScore(mixed $secondPlayerScore): void
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

    public function getSetWinnerId(): int
    {
        if ($this->firstPlayerScore == 0 && $this->secondPlayerScore == 0) {
            return 0;
        }
        if ($this->firstPlayerScore > $this->secondPlayerScore) {
            return 1;
        }
        return 2;
    }
}