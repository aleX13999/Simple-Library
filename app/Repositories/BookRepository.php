<?php

namespace App\Repositories;

use App\Application\Book\Repository\BookRepositoryInterface;
use App\Application\Book\Repository\Contract\BookBySearchFilterDataInterface;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class BookRepository implements BookRepositoryInterface
{
    public function getOne(int $id): ?Book
    {
        return Book::find($id);
    }

    public function getOneByTitle(string $title): ?Book
    {
        return Book::query()->where('title', $title)->first();
    }

    public function getBySearchFilter(BookBySearchFilterDataInterface $searchFilterData): Collection
    {
        $query = Book::with(['author', 'genres'])
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
