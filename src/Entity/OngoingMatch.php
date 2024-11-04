<?php

namespace src\Entity;

class OngoingMatch implements \JsonSerializable
{
    private ?int $ongoingId;
    private Player $player1;
    private Player $player2;
    private Score $sets;
    private Score $games;
    private Score $points;

    /**
     * @param int|null $ongoingId
     * @param Player $player1
     * @param Player $player2
     * @param Score $sets
     * @param Score $games
     * @param Score $points
     */
    public function __construct(?int $ongoingId, Player $player1, Player $player2, Score $sets, Score $games, Score $points)
    {
        $this->ongoingId = $ongoingId;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->sets = $sets;
        $this->games = $games;
        $this->points = $points;
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
        $matchArray = json_decode($serializeMatch);

        $player1 = Player::deserialize((string)$matchArray["player1"]);
        $player2 = Player::deserialize((string)$matchArray["player2"]);

        $sets = Score::deserialize((string)$matchArray["sets"]);
        $games = Score::deserialize((string)$matchArray["games"]);
        $points = Score::deserialize((string)$matchArray["points"]);

        return new OngoingMatch($matchArray["ongoingId"], $player1, $player2, $sets, $games, $points);
    }

    public function jsonSerialize(): array
    {
        return [
            'ongoingId' => $this->ongoingId,
            'player1' => $this->player1,
            'player2' => $this->player2,
            'sets' => $this->sets,
            'games' => $this->games,
            'points' => $this->points
        ];
    }
}