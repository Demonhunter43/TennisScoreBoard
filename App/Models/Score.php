<?php

namespace App\Models;

class Score
{
    private int $player1;
    private int $player2;

    /**
     * @param int $player1
     * @param int $player2
     */
    public function __construct(int $player1, int $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }
    public function getHighest(): int
    {
        return max($this->player1, $this->player2);
    }
}