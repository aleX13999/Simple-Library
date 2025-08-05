<?php

namespace App\Application\Book\Repository\Contract;

use App\Application\Contracts\BySearchFilterDataInterface;

interface BookBySearchFilterDataInterface extends BySearchFilterDataInterface
{
    public function getTitle(): ?string;
    public function getAuthorId(): ?int;
    public function getGenreIds(): ?array;
    public function getIsSortByTitle(): ?bool;
}
