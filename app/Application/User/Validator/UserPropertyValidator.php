<?php

namespace App\Application\User\Validator;

use App\Application\User\Exception\UserValidationException;
use App\Application\User\Repository\UserRepositoryInterface;

readonly class UserPropertyValidator
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    /**
     * @throws UserValidationException
     */
    public function validateEmail(string $email): void
    {
        $book = $this->userRepository->getOneByEmail($email);

        if ($book) {
            throw new UserValidationException("User with email '$email' already exists");
        }
    }
}
