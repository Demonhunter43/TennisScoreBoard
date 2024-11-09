<?php

namespace src\Services;

use src\Database\DatabaseAction;
use src\DTO\MatchDTO;
use src\DTO\PlayerDTO;
use src\Entity\OngoingMatch;

class FinishedMatchesPersistenceService
{

    public static function saveFinishedMatch(OngoingMatch $ongoingMatch): void
    {
        $databaseAction = new DatabaseAction();

        $player1DTO = new PlayerDTO($ongoingMatch->getPlayer1()->getId(), $ongoingMatch->getPlayer1()->getName());
        $player2DTO = new PlayerDTO($ongoingMatch->getPlayer2()->getId(), $ongoingMatch->getPlayer2()->getName());
        $winnerDTO = new PlayerDTO($ongoingMatch->getWinner()->getId(), $ongoingMatch->getWinner()->getName());

        $newMatch = new MatchDTO(null, $player1DTO, $player2DTO, $winnerDTO);
        $databaseAction->addMatch($newMatch);
    }
}