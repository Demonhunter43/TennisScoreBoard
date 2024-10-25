<?php

namespace src\Models;

class TennisMatch
{
    private ?int $id;
    private Player $player1;
    private Player $player2;
    private ?Player $winner;
    private Score $sets;
    private Score $games;
    private Score $points;

    /**
     * @param int|null $id
     * @param Player $player1
     * @param Player $player2
     * @param Player|null $winner
     */
    public function __construct(?int $id, Player $player1, Player $player2, ?Player $winner)
    {
        $this->id = $id;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->winner = $winner;
        $this->sets = new Score(0, 0);
        $this->games = new Score(0, 0);
        $this->points = new Score(0, 0);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
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
}