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
        $query = Book::with(['author', 'genres']);

        if ($searchFilterData->getSkip() !== null and $searchFilterData->getTake() !== null) {
            $query
                ->skip($searchFilterData->getSkip())
                ->take($searchFilterData->getTake());
        }

        if ($searchFilterData->getAuthorId() !== null) {
            $query
                ->where('author_id', $searchFilterData->getAuthorId());
        }

        if ($searchFilterData->getTitle() !== null) {
            $query
                ->where('title', 'like', '%' . $searchFilterData->getTitle() . '%');
        }

        if (($genreIds = $searchFilterData->getGenreIds()) !== null) {
            $query->whereHas('genres', function ($q) use ($genreIds) {
                $q->whereIn('genres.id', $genreIds);
            });
        }

        if ($searchFilterData->getIsSortByTitle() !== null) {
            $query
                ->orderBy('title', $searchFilterData->getIsSortByTitle() ? 'ASC' : 'DESC');
        }

        return $query->get();
    }
}
