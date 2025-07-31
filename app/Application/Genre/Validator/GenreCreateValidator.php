<?php

namespace App\Application\Genre\Validator;

use App\Application\Genre\DTO\GenreCreateData;
use App\Application\Genre\Exception\GenreValidationException;

readonly class GenreCreateValidator
{
    public function __construct(
        private GenrePropertyValidator $propertyValidator,
    ) {}

    /**
     * @throws GenreValidationException
     */
    public function validate(GenreCreateData $data): void
    {
        try {
            $this->propertyValidator->validateName($data->getName());
        } catch (GenreValidationException $exception) {
            throw new GenreValidationException('Genre creation error: ' . $exception->getMessage(), $exception->getCode());
        }
    }
}
