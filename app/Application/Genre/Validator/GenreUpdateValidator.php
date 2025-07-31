<?php

namespace App\Application\Genre\Validator;

use App\Application\Genre\DTO\GenreUpdateData;
use App\Application\Genre\Exception\GenreValidationException;
use App\Application\Genre\Repository\GenreRepositoryInterface;

readonly class GenreUpdateValidator
{
    public function __construct(
        private GenreRepositoryInterface $repository,
        private GenrePropertyValidator   $propertyValidator,
    ) {}

    /**
     * @throws GenreValidationException
     */
    public function validate(GenreUpdateData $data): void
    {
        $genre = $this->repository->getOne($data->getId());

        if (!$genre) {
            return;
        }

        if ($data->getName() !== $genre->name) {
            try {
                $this->propertyValidator->validateName($data->getName());
            } catch (GenreValidationException $exception) {
                throw new GenreValidationException("Genre update error: " . $exception->getMessage(), $exception->getCode());
            }
        }
    }
}
