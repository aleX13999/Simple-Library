<?php

namespace App\Application\Genre\Validator;

use App\Application\Genre\Exception\GenreValidationException;
use App\Application\Genre\Repository\GenreRepositoryInterface;

readonly class GenrePropertyValidator
{
    public function __construct(
        private GenreRepositoryInterface $genreRepository,
    ) {}

    /**
     * @throws GenreValidationException
     */
    public function validateName(string $name): void
    {
        $genre = $this->genreRepository->getOneByName($name);

        if ($genre) {
            throw new GenreValidationException("Genre with name '$name' already exists.");
        }
    }
}
