<?php

namespace App\Application\User\Validator;

use App\Application\User\DTO\UserUpdateData;
use App\Application\User\Exception\UserValidationException;

readonly class UserUpdateValidator
{
    private const UPDATE_ERROR_MESSAGE = "Update user error: ";

    public function __construct(
        private UserPropertyValidator $propertyValidator,
    ) {}

    /**
     * @throws UserValidationException
     */
    public function validate(UserUpdateData $data): void
    {
        if ($data->hasEmail()) {
            try {
                $this->propertyValidator->validateEmail($data->getEmail());
            } catch (UserValidationException $exception) {
                throw new UserValidationException(self::UPDATE_ERROR_MESSAGE . $exception->getMessage(), $exception->getCode());
            }
        }
    }
}
