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
        $sql = "SELECT  matches.id,
                        Player1.name AS Player1_Name,
                        Player2.name AS Player2_Name,
                        Winner.name AS Winner_Name
                FROM matches
                JOIN players AS player1
                ON player1.id = matches.player1id
                JOIN players AS player2
                ON player2.id = matches.player2id
                JOIN players AS winner
                ON winner.id = matches.winnerid;";

        $stmt = $this->connection->getPdo()->prepare($sql);
        $stmt->execute();
        return $this->makeObjectsArray(($stmt->fetchAll(\PDO::FETCH_ASSOC)));
    }

    /**
     * @throws \Exception
     */
    public function addPlayer(PlayerDTO $playerDTO): PlayerDTO
    {
        $sql = "INSERT INTO players
        (name) VALUES (:playerName)";
        $stmt = $this->connection->getPdo()->prepare($sql);
        $stmt->execute([
            'playerName' => $playerDTO->getName()
        ]);
        return $this->getPlayerByName($playerDTO->getName());
    }

    /**
     * @throws \Exception
     */
    public function getPlayerByName(string $name): PlayerDTO
    {
        $sql = "SELECT * FROM players WHERE name=:playerName";
        $stmt = $this->connection->getPdo()->prepare($sql);
        $stmt->execute([
            'playerName' => $name
        ]);

        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (!array_key_exists(0, $data)) {
            throw new \Exception("No this player in database");
        }
        return $this->makeObject($data[0]);
    }


    public function addMatch(MatchDTO $matchDTO): void
    {
        $sql = "INSERT INTO matches
        (player1id, player2id, winnerid) VALUES (:player1Id, :player2Id, :winnerId)";
        $stmt = $this->connection->getPdo()->prepare($sql);
        $stmt->execute([
            'player1Id' => $matchDTO->getPlayer1Id(),
            'player2Id' => $matchDTO->getPlayer2Id(),
            'winnerId' => $matchDTO->getWinnerId()
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