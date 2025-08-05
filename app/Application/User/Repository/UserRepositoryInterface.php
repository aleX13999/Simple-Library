<?php

namespace App\Application\User\Repository;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getOne(int $id): ?User;
    public function getOneByEmail(string $email): ?User;
}
