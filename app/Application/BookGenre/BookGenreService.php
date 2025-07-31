<?php

namespace App\Application\BookGenre;

use App\Application\Book\Exception\BookException;
use App\Application\Book\Service\BookGetter;
use App\Application\BookGenre\Exception\BookGenreException;
use App\Application\Genre\Repository\GenreRepositoryInterface;

readonly class BookGenreService
{
    public function __construct(
        private BookGetter               $bookGetter,
        private GenreRepositoryInterface $genreRepository,
    ) {}

    /**
     * @throws BookException
     * @throws BookGenreException
     */
    public function sync(int $bookId, ?array $genreIds): void
    {
        if ($genreIds === null) {
            return;
        }

        $book = $this->bookGetter->get($bookId);

        $validGenreIds = [];

        $validGenres = $this->genreRepository->getByIds($genreIds);
        foreach ($validGenres as $genre) {
            $validGenreIds[] = $genre->id;
        }

        try {
            $book->genres()->sync($validGenreIds);
        } catch (\Exception $e) {
            throw new BookGenreException($e->getMessage(), BookGenreException::SYNC_ERROR);
        }
    }
}
