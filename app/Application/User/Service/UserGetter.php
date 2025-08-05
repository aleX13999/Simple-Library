<?php

namespace App\Application\User\Service;

use App\Application\User\Exception\UserException;
use App\Application\User\Repository\UserRepositoryInterface;
use App\Models\User;

readonly class UserGetter
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    /**
     * @throws UserException
     */
    public function get(int $id): User
    {
        $user = $this->userRepository->getOne($id);

        if (!$user) {
            throw new UserException("User with id '$id' not found");
        }

        return $user;
    }
}
