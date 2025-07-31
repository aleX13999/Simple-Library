<?php

namespace App\Application\Author\Repository;

use App\Application\Author\Repository\Contract\AuthorBySearchFilterDataInterface;
use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

interface AuthorRepositoryInterface
{
    public function getOne(int $id): ?Author;
    public function getBySearchFilter(AuthorBySearchFilterDataInterface $searchFilterData): Collection;
}
