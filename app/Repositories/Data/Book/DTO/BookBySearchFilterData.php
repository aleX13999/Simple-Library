<?php

namespace App\Repositories\Data\Book\DTO;

use App\Application\Book\Repository\Contract\BookBySearchFilterDataInterface;

class BookBySearchFilterData implements BookBySearchFilterDataInterface
{
    private ?int    $skip          = null;
    private ?int    $take          = null;
    private ?int    $authorId      = null;
    private ?string $title         = null;
    private ?array  $genreIds      = null;
    private ?bool   $isSortByTitle = null;

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

    public function getAuthorId(): ?int
    {
        return $this->authorId;
    }

    public function setAuthorId(?int $authorId): static
    {
        $this->authorId = $authorId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getGenreIds(): ?array
    {
        return $this->genreIds;
    }

    public function setGenreIds(?array $genreIds): static
    {
        $this->genreIds = $genreIds;

        return $this;
    }

    public function getIsSortByTitle(): ?bool
    {
        return $this->isSortByTitle;
    }

    public function setIsSortByTitle(?bool $isSortByTitle): static
    {
        $this->isSortByTitle = $isSortByTitle;

        return $this;
    }
}
