<?php

namespace src\Entity;

class Player implements \JsonSerializable
{
    private ?int $id;
    private string $name;

    /**
     * @param int|null $id
     * @param string $name
     */
    public function __construct(?int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public static function deserialize(array $arrayPlayer): self
    {
        return new Player($arrayPlayer["id"], $arrayPlayer["name"]);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }

}