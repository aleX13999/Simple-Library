<?php

namespace App\Application\Author\DTO;

class AuthorUpdateData
{
    private const FIRST_NAME = 'firstName';
    private const LAST_NAME  = 'lastName';
    private const PATRONYMIC = 'patronymic';

    private array $data = [];

    public function __construct(
        private readonly int $id,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->data[self::FIRST_NAME];
    }

    public function setFirstName(string $firstName): static
    {
        $this->data[self::FIRST_NAME] = $firstName;

        return $this;
    }

    public function hasFirstName(): bool
    {
        return array_key_exists(self::FIRST_NAME, $this->data);
    }

    public function getLastName(): string
    {
        return $this->data[self::LAST_NAME];
    }

    public function setLastName(string $lastName): static
    {
        $this->data[self::LAST_NAME] = $lastName;

        return $this;
    }

    public function hasLastName(): bool
    {
        return array_key_exists(self::LAST_NAME, $this->data);
    }

    public function getPatronymic(): ?string
    {
        return $this->data[self::PATRONYMIC];
    }

    public function setPatronymic(?string $patronymic): static
    {
        $this->data[self::PATRONYMIC] = $patronymic;

        return $this;
    }

    public function hasPatronymic(): bool
    {
        return array_key_exists(self::PATRONYMIC, $this->data);
    }
}
