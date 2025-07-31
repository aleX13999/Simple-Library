<?php

namespace App\Application\Genre\DTO;

class GenreUpdateData
{
    private const NAME = 'name';

    private array $data = [];

    public function __construct(
        private readonly int $id,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->data[self::NAME];
    }

    public function setName(string $firstName): static
    {
        $this->data[self::NAME] = $firstName;

        return $this;
    }

    public function hasName(): bool
    {
        return array_key_exists(self::NAME, $this->data);
    }
}
