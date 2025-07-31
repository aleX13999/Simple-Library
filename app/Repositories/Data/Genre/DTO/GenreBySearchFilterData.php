<?php

namespace App\Repositories\Data\Genre\DTO;

use App\Application\Genre\Repository\Contract\GenreBySearchFilterDataInterface;

class GenreBySearchFilterData implements GenreBySearchFilterDataInterface
{
    private ?int $skip = null;
    private ?int $take = null;

    public function getSkip(): ?int
    {
        return $this->skip;
    }

    public function setSkip(?int $skip): static
    {
        $this->skip = $skip;

        return $this;
    }

    public function getTake(): ?int
    {
        return $this->take;
    }

    public function setTake(?int $take): static
    {
        $this->take = $take;

        return $this;
    }
}
