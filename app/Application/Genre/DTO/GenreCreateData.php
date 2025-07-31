<?php

namespace App\Application\Genre\DTO;

class GenreCreateData
{
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
