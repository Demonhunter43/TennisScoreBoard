<?php

namespace src\Entity;

class OngoingMatch implements \JsonSerializable
{
    private ?int $ongoingId;
    private Player $player1;
    private Player $player2;
    private ?Player $winner;
    private int $finishedSetsCounter;
    private ?array $gamesInSets;
    private Score $points;


    public function __construct(?int $ongoingId, Player $player1, Player $player2, Score $points = new Score(0, 0), int $finishedSetsCounter = 0, array $gamesInSets = null, ?Player $winner = null)
    {
        $this->ongoingId = $ongoingId;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->winner = $winner;
        $this->finishedSetsCounter = $finishedSetsCounter;
        $this->points = $points;
        if (is_null($gamesInSets)) {
            for ($i = 0; $i < 5; $i++) {
                $this->gamesInSets[$i] = new Score(0, 0);
            }
        } else {
            $this->gamesInSets = $gamesInSets;
        }
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

    public function getSets(): Score
    {
        return $this->sets;
    }

    public function setSets(Score $sets): void
    {
        $this->sets = $sets;
    }

    public function getGames(): Score
    {
        return $this->games;
    }

    public function setGames(Score $games): void
    {
        $this->games = $games;
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


        $points = Score::deserialize((array)$matchArray["points"]);

        $gamesInSetsData = $matchArray["gamesInSets"];
        for ($i = 0; $i<5; $i++){
            $gamesInSets[$i] = Score::deserialize((array)$gamesInSetsData[$i]);
        }
        return new OngoingMatch($matchArray["ongoingId"], $player1, $player2, $points, $matchArray["finishedSetsCounter"], $gamesInSets);
    }

    public function jsonSerialize(): array
    {
        return [
            'ongoingId' => $this->ongoingId,
            'player1' => $this->player1,
            'player2' => $this->player2,
            'finishedSetsCounter' => $this->finishedSetsCounter,
            'gamesInSets' => $this->gamesInSets,
            'points' => $this->points,
            'winner' => $this->winner
        ];
    }
}