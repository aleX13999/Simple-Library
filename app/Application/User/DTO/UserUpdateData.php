<?php

namespace App\Application\User\DTO;

class UserUpdateData
{
    private const NAME     = 'name';
    private const EMAIL    = 'email';
    private const PASSWORD = 'password';

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

    public function setName(string $name): static
    {
        $this->data[self::NAME] = $name;

        return $this;
    }

    public function hasName(): bool
    {
        return array_key_exists(self::NAME, $this->data);
    }

    public function getEmail(): string
    {
        return $this->data[self::EMAIL];
    }

    public function setEmail(string $email): static
    {
        $this->data[self::EMAIL] = $email;

        return $this;
    }

    public function hasEmail(): bool
    {
        return array_key_exists(self::EMAIL, $this->data);
    }

    public function getPassword(): string
    {
        return $this->data[self::PASSWORD];
    }

    public function setPassword(string $password): static
    {
        $this->data[self::PASSWORD] = $password;

        return $this;
    }

    public function hasPassword(): bool
    {
        return array_key_exists(self::PASSWORD, $this->data);
    }
}
