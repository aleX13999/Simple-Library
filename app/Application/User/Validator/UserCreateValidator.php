<?php

namespace App\Application\User\Validator;

use App\Application\User\DTO\UserCreateData;
use App\Application\User\Exception\UserValidationException;

readonly class UserCreateValidator
{
    private const CREATE_ERROR_MESSAGE = "Creating user error: ";

    public function __construct(
        private UserPropertyValidator $propertyValidator,
    ) {}

    /**
     * @throws UserValidationException
     */
    public function validate(UserCreateData $data): void
    {
        try {
            $this->propertyValidator->validateEmail($data->getEmail());
        } catch (UserValidationException $exception) {
            throw new UserValidationException(self::CREATE_ERROR_MESSAGE . $exception->getMessage(), $exception->getCode());
        }
    }
}
