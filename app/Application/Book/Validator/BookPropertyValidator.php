<?php

namespace App\Application\Book\Validator;

use App\Application\Author\Repository\AuthorRepositoryInterface;
use App\Application\Book\Enum\BookTypeEnum;
use App\Application\Book\Exception\BookValidationException;
use App\Application\Book\Repository\BookRepositoryInterface;

readonly class BookPropertyValidator
{
    public function __construct(
        private AuthorRepositoryInterface $authorRepository,
        private BookRepositoryInterface   $bookRepository,
    ) {}

    /**
     * @throws BookValidationException
     */
    public function validateAuthorId(int $authorId): void
    {
        $author = $this->authorRepository->getOne($authorId);

        if (!$author) {
            throw new BookValidationException("Author with id '$authorId' not found");
        }
    }

    /**
     * @throws BookValidationException
     */
    public function validateTitle(string $title): void
    {
        $book = $this->bookRepository->getOneByTitle($title);

        if ($book) {
            throw new BookValidationException("Book with title '$title' already exists");
        }
    }

    /**
     * @throws BookValidationException
     */
    public function validateType(string $type): void
    {
        if (!BookTypeEnum::tryFrom($type)) {
            throw new BookValidationException("Book type '$type' is not allowed");
        }
    }
}
