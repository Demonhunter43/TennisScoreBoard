<?php

namespace src\Database;


use src\DTO\MatchDTO;
use src\DTO\PlayerDTO;

class DatabaseAction
{
    private Connection $connection;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * @return MatchDTO[]
     */
    public function getAllMatches(): array
    {
        $sql = "SELECT  matches.ID,
                        Player1.Name AS Player1_Name,
                        Player2.Name AS Player2_Name,
                        Winner.Name AS Winner_Name
                FROM matches
                JOIN players AS player1
                ON player1.ID = matches.player1id
                JOIN players AS player2
                ON player2.ID = matches.player2id
                JOIN players AS winner
                ON winner.ID = matches.winnerid;";

        $stmt = $this->connection->getPdo()->prepare($sql);
        $stmt->execute();
        return $this->makeObjectsArray(($stmt->fetchAll(\PDO::FETCH_ASSOC)));
    }

    public function isPlayerPresentedInDatabase(PlayerDTO $player): bool
    {
        $playerName = $player->getName();
        $sql = "SELECT EXISTS(SELECT 1 FROM players WHERE Name=:playerName);";
        $stmt = $this->connection->getPdo()->prepare($sql);
        $stmt->execute([
            'playerName' => $playerName
        ]);
        $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return true;
    }

    public function addFinishedMatch(MatchDTO $matchDTO): void
    {
        //TODO to implement this
        $code = $currency->getCode();
        $fullName = $currency->getFullName();
        $sign = $currency->getSign();
        $sql = "INSERT INTO `currencies` 
                (ID, Code, FullName, Sign) VALUES (null, :code, :fullName, :sign)";

        $stmt = $this->connection->getPdo()->prepare($sql);
        $stmt->execute([
            'code' => $code,
            'fullName' => $fullName,
            'sign' => $sign
        ]);
    }

    public function makeObjectsArray($data): array
    {
        $i = 0;
        foreach ($data as $objectData) {
            $array[$i] = $this->makeObject($objectData);
            $i++;
        }
        return $array;
    }

    public function makeObject(array $dataObject): MatchDTO|PlayerDTO
    {
        if (array_key_exists("name", $dataObject)) {
            return new PlayerDTO($dataObject["id"], $dataObject["name"]);
        } else {
            $player1DTO = new PlayerDTO($dataObject["id"], $dataObject["player1_name"]);
            $player2DTO = new PlayerDTO($dataObject["id"], $dataObject["player2_name"]);
            if ($player1DTO->getName() == $dataObject["winner_name"]) {
                $winnerDTO = $player1DTO;
            } else {
                $winnerDTO = $player2DTO;
            }
            return new MatchDTO($dataObject["id"], $player1DTO, $player2DTO, $winnerDTO);
        }
    }
}