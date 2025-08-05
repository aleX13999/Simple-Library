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
        return Author::with('books')->find($id);
    }

    public function getBySearchFilter(AuthorBySearchFilterDataInterface $searchFilterData): Collection
    {
        $query = Author::withCount('books')
            ->orderBy('id');

        if ($searchFilterData->getSkip() !== null and $searchFilterData->getTake() !== null) {
            $query
                ->skip($searchFilterData->getSkip())
                ->take($searchFilterData->getTake());
        }

        return $query->get();
    }
}
