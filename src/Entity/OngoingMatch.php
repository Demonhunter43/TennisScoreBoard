<?php

namespace src\Entity;

class OngoingMatch implements \JsonSerializable
{
    private ?int $ongoingId;
    private Player $player1;
    private Player $player2;
    private ?Player $winner;
    private bool $isTieBreak;
    private int $finishedSetsCounter;
    private int $numberOfSets;
    private ?array $gamesInSets;
    private Score $points;


    public function __construct(?int    $ongoingId,
                                Player  $player1,
                                Player  $player2,
                                int     $numberOfSets,
                                Score   $points = new Score(0, 0),
                                int     $finishedSetsCounter = 0,
                                array   $gamesInSets = null,
                                ?Player $winner = null,
                                bool    $isTieBreak = false)
    {
        $this->ongoingId = $ongoingId;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->numberOfSets = $numberOfSets;
        $this->winner = $winner;
        $this->finishedSetsCounter = $finishedSetsCounter;
        $this->points = $points;
        $this->isTieBreak = $isTieBreak;
        if (is_null($gamesInSets)) {
            for ($i = 0; $i < 5; $i++) {
                $this->gamesInSets[$i] = new Score(0, 0);
            }
        } else {
            $this->gamesInSets = $gamesInSets;
        }
    }

    public function isTieBreak(): bool
    {
        return $this->isTieBreak;
    }

    public function setIsTieBreak(bool $isTieBreak): void
    {
        $this->isTieBreak = $isTieBreak;
    }


    public function getPlayer1(): Player
    {
        return $this->player1;
    }


    public function getPlayer2(): Player
    {
        return $this->player2;
    }


    public function getWinner(): ?Player
    {
        return $this->winner;
    }

    public function setWinner(?Player $winner): void
    {
        $this->winner = $winner;
    }


    public function getPoints(): Score
    {
        return $this->points;
    }

    public function setPoints(Score $points): void
    {
        $this->points = $points;
    }


    public function getOngoingId(): ?int
    {
        return $this->ongoingId;
    }

    public function setOngoingId(?int $ongoingId): void
    {
        $this->ongoingId = $ongoingId;
    }

    public static function deserialize(string $serializeMatch): self
    {
        $matchArray = (array)json_decode($serializeMatch);

        $player1 = Player::deserialize((array)$matchArray["player1"]);
        $player2 = Player::deserialize((array)$matchArray["player2"]);
        $winner = null;


        $points = Score::deserialize((array)$matchArray["points"]);

        $gamesInSetsData = $matchArray["gamesInSets"];
        $gamesInSets = null;
        for ($i = 0; $i < $matchArray["numberOfSets"]; $i++) {
            $gamesInSets[$i] = Score::deserialize((array)$gamesInSetsData[$i]);
        }
        return new OngoingMatch($matchArray["ongoingId"], $player1, $player2, $matchArray["numberOfSets"]
            , $points, $matchArray["finishedSetsCounter"], $gamesInSets,  $winner, $matchArray["isTieBreak"]);
    }

    public function getNumberOfSets(): int
    {
        return $this->numberOfSets;
    }

    public function getFinishedSetsCounter(): int
    {
        return $this->finishedSetsCounter;
    }

    public function getGamesInSets(): ?array
    {
        return $this->gamesInSets;
    }


    public function jsonSerialize(): array
    {
        return [
            'ongoingId' => $this->ongoingId,
            'player1' => $this->player1,
            'player2' => $this->player2,
            'numberOfSets' => $this->numberOfSets,
            'finishedSetsCounter' => $this->finishedSetsCounter,
            'gamesInSets' => $this->gamesInSets,
            'points' => $this->points,
            'winner' => $this->winner,
            'isTieBreak' => $this->isTieBreak
        ];
    }

    public function setGamesInCurrentSet(Score $gamesInCurrentSet): void
    {
        $this->gamesInSets[$this->finishedSetsCounter] = $gamesInCurrentSet;
    }

    public function setFinishedSetsCounter(int $finishedSetsCounter): void
    {
        $this->finishedSetsCounter = $finishedSetsCounter;
    }

    public function getPlayerByInMatchId(int $playerInMatchId): Player
    {
        if ($playerInMatchId == 1) {
            return $this->player1;
        } else {
            return $this->player2;
        }
    }
}