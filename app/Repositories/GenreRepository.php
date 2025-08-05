<?php

namespace App\Repositories;

use App\Application\Genre\Repository\GenreRepositoryInterface;
use App\Application\Genre\Repository\Contract\GenreBySearchFilterDataInterface;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;

class GenreRepository implements GenreRepositoryInterface
{
    public function getOne(int $id): ?Genre
    {
        return Genre::find($id);
    }

    public function getOneByName(string $name): ?Genre
    {
        return Genre::query()->where("name", $name)->first();
    }

    public function getByIds(array $ids): Collection
    {
        return Genre::query()->whereIn('id', $ids)->get();
    }

    public function getWithBookCountBySearchFilter(GenreBySearchFilterDataInterface $searchFilterData): Collection
    {
        $query = Genre::query()->withCount('books')->orderBy('id');

        if ($searchFilterData->getSkip() !== null and $searchFilterData->getTake() !== null) {
            $query
                ->skip($searchFilterData->getSkip())
                ->take($searchFilterData->getTake());
        }

        return $query->get();
    }

    public function getBySearchFilter(GenreBySearchFilterDataInterface $searchFilterData): Collection
    {
        $query = Genre::query()->orderBy('id');

        if ($searchFilterData->getSkip() !== null and $searchFilterData->getTake() !== null) {
            $query
                ->skip($searchFilterData->getSkip())
                ->take($searchFilterData->getTake());
        }

        return $query->get();
    }
}
