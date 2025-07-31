<?php

namespace App\Application\Book\Repository;

use App\Application\Book\Repository\Contract\BookBySearchFilterDataInterface;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

interface BookRepositoryInterface
{
    public function getOne(int $id): ?Book;
    public function getOneByTitle(string $title): ?Book;
    public function getBySearchFilter(BookBySearchFilterDataInterface $searchFilterData): Collection;
}
