<?php

namespace App\Application\Author\Validator;

use App\Application\Author\Exception\AuthorValidationException;
use App\Application\User\Repository\UserRepositoryInterface;

readonly class AuthorPropertyValidator
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    /**
     * @throws AuthorValidationException
     */
    public function validateUserId(int $userId): void
    {
        $user = $this->userRepository->getOne($userId);

        if (!$user) {
            throw new AuthorValidationException("User with id '$userId' not found");
        }
    }
}
