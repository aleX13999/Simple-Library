<?php

namespace App\Application\Author\Validator;

use App\Application\Author\DTO\AuthorCreateData;
use App\Application\Author\Exception\AuthorValidationException;

readonly class AuthorCreateValidator
{
    public function __construct(
        private AuthorPropertyValidator $propertyValidator,
    ) {}

    /**
     * @throws AuthorValidationException
     */
    public function validate(AuthorCreateData $data): void
    {
        try {
            $this->propertyValidator->validateUserId($data->getUserId());
        } catch (AuthorValidationException $exception) {
            throw new AuthorValidationException('Creating author error: ' . $exception->getMessage(), $exception->getCode());
        }
    }
}
