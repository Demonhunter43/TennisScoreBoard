<?php

namespace App\Models;

class TennisMatch
{
    private ?int $id;
    private Player $player1;
    private Player $player2;
    private ?Player $winner;
    private ?Score $score;

    /**
     * @param int|null $id
     * @param Player $player1
     * @param Player $player2
     * @param Player|null $winner
     * @param Score|null $score
     */
    public function __construct(?int $id, Player $player1, Player $player2, ?Player $winner, Score $score = null)
    {
        $this->id = $id;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->winner = $winner;
        $this->score = $score;
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

    public function setPlayer1(Player $player1): void
    {
        $this->player1 = $player1;
    }

    public function getPlayer2(): Player
    {
        return $this->player2;
    }

    public function setPlayer2(Player $player2): void
    {
        $this->player2 = $player2;
    }

    public function getWinner(): Player
    {
        return $this->winner;
    }

    public function setWinner(Player $winner): void
    {
        $this->winner = $winner;
    }
    public function setScore(Score $newScore): void
    {
        $this->score = $newScore;
    }
}