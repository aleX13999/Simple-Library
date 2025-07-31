<?php

namespace App\Application\Book\Validator;

use App\Application\Book\DTO\BookCreateData;
use App\Application\Book\Exception\BookValidationException;

readonly class BookCreateValidator
{
    public function __construct(
        private BookPropertyValidator $propertyValidator,
    ) {}

    /**
     * @throws BookValidationException
     */
    public function validate(BookCreateData $data): void
    {
        try {
            $this->propertyValidator->validateAuthorId($data->getAuthorId());
            $this->propertyValidator->validateTitle($data->getTitle());
            $this->propertyValidator->validateTitle($data->getType());
        } catch (BookValidationException $exception) {
            throw new BookValidationException('Creating book error: ' . $exception->getMessage(), $exception->getCode());
        }
    }
}
