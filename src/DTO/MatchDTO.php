<?php

namespace src\DTO;

class MatchDTO
{
    private readonly ?int $id;
    private readonly PlayerDTO $player1;
    private readonly PlayerDTO $player2;
    private readonly PlayerDTO $winner;

    /**
     * @param int|null $id
     * @param PlayerDTO $player1
     * @param PlayerDTO $player2
     * @param PlayerDTO $winner
     */
    public function __construct(?int $id, PlayerDTO $player1, PlayerDTO $player2, PlayerDTO $winner)
    {
        $this->id = $id;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->winner = $winner;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer1Name(): string
    {
        return $this->player1->getName();
    }

    public function getPlayer2Name(): string
    {
        return $this->player2->getName();
    }
    public function getPlayer1Id(): int
    {
        return $this->player1->getId();
    }

    public function getPlayer2Id(): int
    {
        return $this->player2->getId();
    }

    public function getWinnerName(): string
    {
        return $this->winner->getName();
    }
    public function getWinnerId(): int
    {
        return $this->winner->getId();
    }
}