<?php

namespace App\Application\Author\Service;

use App\Application\Author\Exception\AuthorException;
use App\Application\Author\Repository\AuthorRepositoryInterface;
use App\Models\Author;

readonly class AuthorGetter
{
    public function __construct(
        private AuthorRepositoryInterface $authorRepository,
    ) {}

    /**
     * @throws AuthorException
     */
    public function get(int $id): Author
    {
        $author = $this->authorRepository->getOne($id);

        if (!$author) {
            throw new AuthorException("Author with id '$id' not found");
        }

        return $author;
    }
}
