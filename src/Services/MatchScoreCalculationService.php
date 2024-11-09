<?php

namespace src\Services;

use src\Entity\OngoingMatch;
use src\Entity\Score;

class MatchScoreCalculationService
{
    public static function calculate(OngoingMatch $ongoingMatch, int $pointWinnerId): OngoingMatch
    {
        $newWinnerPoints = $newLoserPoints = -1;
        $currentPoints = $ongoingMatch->getPoints();
        $serveWinnerInMatchId = self::getServeWinnerInMatchById($ongoingMatch, $pointWinnerId);

        if ($ongoingMatch->isTieBreak()) {
            return self::calculateInTieBreak($ongoingMatch, $serveWinnerInMatchId);
        }

        $serveLoserInMatchId = 3 - $serveWinnerInMatchId;
        $currentWinnerPoints = $currentPoints->getPlayerScoreByInMatchId($serveWinnerInMatchId);
        $currentLoserPoint = $currentPoints->getPlayerScoreByInMatchId($serveLoserInMatchId);
        switch ($currentWinnerPoints) {
            case 0:
            case 15:
                $newWinnerPoints = $currentWinnerPoints + 15;
                $newLoserPoints = $currentLoserPoint;
                break;
            case 30:
                $newWinnerPoints = 40;
                $newLoserPoints = $currentLoserPoint;
                break;
            case 40:
                switch ($currentLoserPoint) {
                    case "AD":
                        $newWinnerPoints = 40;
                        $newLoserPoints = 40;
                        break;
                    case 40:
                        $newWinnerPoints = "AD";
                        $newLoserPoints = $currentLoserPoint;
                        break;
                    default:
                        $ongoingMatch->setPoints(new Score(0, 0));
                        return self::calculateAfterWonGame($ongoingMatch, $serveWinnerInMatchId);
                }
                break;
            case "AD":
                $ongoingMatch->setPoints(new Score(0, 0));
                return self::calculateAfterWonGame($ongoingMatch, $serveWinnerInMatchId);
        }
        $currentPoints->setPlayerScoreByInMatchId($newWinnerPoints, $serveWinnerInMatchId);
        $currentPoints->setPlayerScoreByInMatchId($newLoserPoints, $serveLoserInMatchId);
        $updatedOngoingMatch = $ongoingMatch;
        $updatedOngoingMatch->setPoints($currentPoints);
        return $updatedOngoingMatch;
    }

    private static function calculateAfterWonGame(OngoingMatch $ongoingMatch, int $gameWinnerInMatchId): OngoingMatch
    {
        $currentSetNumber = $ongoingMatch->getFinishedSetsCounter();

        /**
         * @var Score $gamesInCurrentSet
         */

        $gamesInCurrentSet = $ongoingMatch->getGamesInSets()[$currentSetNumber];
        $gamesInCurrentSet->setPlayerScoreByInMatchId
        ($gamesInCurrentSet->getPlayerScoreByInMatchId($gameWinnerInMatchId) + 1, $gameWinnerInMatchId);

        if ($gamesInCurrentSet->getHighestScore() >= 6 && $gamesInCurrentSet->isAllowedDifference()) {
            return self::calculateAfterWonSet($ongoingMatch, $gameWinnerInMatchId);
        }
        if ($gamesInCurrentSet->getFirstPlayerScore() == 6 && $gamesInCurrentSet->getSecondPlayerScore() == 6) {
            $ongoingMatch->setIsTieBreak(true);
            $ongoingMatch->setPoints(new Score ("Tie-break", "Tie-break"));
        }
        $ongoingMatch->setGamesInCurrentSet($gamesInCurrentSet);
        return $ongoingMatch;
    }


    private static function calculateInTieBreak(OngoingMatch $ongoingMatch, int $serveWinnerInMatchId): OngoingMatch
    {
        $currentSetNumber = $ongoingMatch->getFinishedSetsCounter();

        /**
         * @var Score $gamesInCurrentSet
         */

        $gamesInCurrentSet = $ongoingMatch->getGamesInSets()[$currentSetNumber];
        $gamesInCurrentSet->setPlayerScoreByInMatchId
        ($gamesInCurrentSet->getPlayerScoreByInMatchId($serveWinnerInMatchId) + 1, $serveWinnerInMatchId);
        if ($gamesInCurrentSet->isAllowedDifference()) {
            $ongoingMatch->setIsTieBreak(false);
            $ongoingMatch->setPoints(new Score (0, 0));
            return self::calculateAfterWonSet($ongoingMatch, $serveWinnerInMatchId);
        }
        $ongoingMatch->setGamesInCurrentSet($gamesInCurrentSet);
        return $ongoingMatch;
    }

    private static function calculateAfterWonSet(OngoingMatch $ongoingMatch, int $potentialWinner): OngoingMatch
    {
        $gamesInSetsArray = $ongoingMatch->getGamesInSets();
        /**
         * @var Score $gamesInSet
         */
        $wonSetCounter = 0;
        foreach ($gamesInSetsArray as $gamesInSet) {
            if ($gamesInSet->getSetWinnerId() == $potentialWinner) {
                $wonSetCounter++;
            }
        }
        if ($wonSetCounter > ($ongoingMatch->getNumberOfSets() / 2)) {
            $winner = $ongoingMatch->getPlayerByInMatchId($potentialWinner);
            $ongoingMatch->setWinner($winner);
        }
        $ongoingMatch->setFinishedSetsCounter($ongoingMatch->getFinishedSetsCounter() + 1);
        return $ongoingMatch;
    }

    private static function getServeWinnerInMatchById(OngoingMatch $ongoingMatch, int $pointWinnerId): int
    {
        if ($ongoingMatch->getPlayer1()->getId() == $pointWinnerId) {
            return 1;
        }
        return 2;
    }
}