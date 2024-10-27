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
                        Player1.Name AS Player1Name,
                        Player2.Name AS Player2Name,
                        Winner.Name AS WinnerName
                FROM `matches`
                JOIN `players` AS player1
                ON player1.ID = matches.Player1
                JOIN `players` AS player2
                ON player2.ID = matches.Player2
                JOIN `players` AS winner
                ON winner.ID = matches.Winner;";

        $stmt = $this->connection->getPdo()->prepare($sql);
        $stmt->execute();
        return $this->makeObjectsArray(($stmt->fetchAll(\PDO::FETCH_ASSOC)));
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
        if (array_key_exists("Name", $dataObject)) {
            return new PlayerDTO($dataObject["ID"], $dataObject["Name"]);
        } else {
            $player1DTO = new PlayerDTO($dataObject["ID"], $dataObject["Player1Name"]);
            $player2DTO = new PlayerDTO($dataObject["ID"], $dataObject["Player2Name"]);
            if ($player1DTO->getName() == $dataObject["WinnerName"]) {
                $winnerDTO = $player1DTO;
            } else {
                $winnerDTO = $player2DTO;
            }
            return new MatchDTO($dataObject["ID"], $player1DTO, $player2DTO, $winnerDTO);
        }
    }
}