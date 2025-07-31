<?php

namespace App\Application\Book\Service;

use App\Application\Book\Exception\BookException;
use App\Application\Book\Repository\BookRepositoryInterface;
use App\Models\Book;

readonly class BookGetter
{
    public function __construct(
        private BookRepositoryInterface $bookRepository,
    ) {}

    /**
     * @throws BookException
     */
    public function get(int $id): Book
    {
        $book = $this->bookRepository->getOne($id);

        if (!$book) {
            throw new BookException("Book with id '$id' not found");
        }

        return $book;
    }
}
