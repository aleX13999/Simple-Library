<?php

namespace App\Repositories;

use App\Application\Author\Repository\AuthorRepositoryInterface;
use App\Application\Author\Repository\Contract\AuthorBySearchFilterDataInterface;
use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function getOne(int $id): ?Author
    {
        return Author::find($id);
    }

    public function getBySearchFilter(AuthorBySearchFilterDataInterface $searchFilterData): Collection
    {
        $query = Author::with([])
            ->orderBy('id');

        if ($searchFilterData->getSkip() !== null) {
            $query
                ->skip($searchFilterData->getSkip());
        }

        if ($searchFilterData->getTake() !== null) {
            $query
                ->take($searchFilterData->getTake());
        }

        return $query->get();
    }
}
