<?php

namespace App\Application\Genre\Repository;

use App\Application\Genre\Repository\Contract\GenreBySearchFilterDataInterface;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;

interface GenreRepositoryInterface
{
    public function getOne(int $id): ?Genre;
    public function getOneByName(string $name): ?Genre;
    public function getByIds(array $ids): Collection;
    public function getBySearchFilter(GenreBySearchFilterDataInterface $searchFilterData): Collection;
}
