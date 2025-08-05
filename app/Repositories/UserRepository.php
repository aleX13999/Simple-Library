<?php

namespace App\Repositories;

use App\Application\User\Repository\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function getOne(int $id): ?User
    {
        return User::find($id);
    }

    public function getOneByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }
}
