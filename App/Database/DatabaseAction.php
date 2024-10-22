<?php

namespace App\Database;


use App\DTO\MatchDTO;

class DatabaseAction
{
    private Connection $connection;
    private TransformerDTO $transformerDTO;

    public function __construct()
    {
        $this->connection = new Connection();
        $this->transformerDTO = new TransformerDTO();
    }

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
        return $this->transformerDTO->makeObjectsArray(($stmt->fetchAll(\PDO::FETCH_ASSOC)));
    }

    public function addMatch(MatchDTO $matchDTO): void
    {
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
}