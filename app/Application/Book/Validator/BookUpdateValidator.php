<?php

namespace App\Application\Book\Validator;

use App\Application\Book\DTO\BookUpdateData;
use App\Application\Book\Exception\BookValidationException;

readonly class BookUpdateValidator
{
    private const UPDATE_ERROR_MESSAGE = "Update book error: ";

    public function __construct(
        private BookPropertyValidator $propertyValidator,
    ) {}

    /**
     * @throws BookValidationException
     */
    public function validate(BookUpdateData $data): void
    {
        if ($data->hasAuthorId()) {
            try {
                $this->propertyValidator->validateAuthorId($data->getAuthorId());
            } catch (BookValidationException $exception) {
                throw new BookValidationException(self::UPDATE_ERROR_MESSAGE . $exception->getMessage(), $exception->getCode());
            }
        }

        if ($data->hasTitle()) {
            try {
                $this->propertyValidator->validateTitle($data->getTitle());
            } catch (BookValidationException $exception) {
                throw new BookValidationException(self::UPDATE_ERROR_MESSAGE . $exception->getMessage(), $exception->getCode());
            }
        }

        if ($data->hasType()) {
            try {
                $this->propertyValidator->validateType($data->getType());
            } catch (BookValidationException $exception) {
                throw new BookValidationException(self::UPDATE_ERROR_MESSAGE . $exception->getMessage(), $exception->getCode());
            }
        }
    }
}
