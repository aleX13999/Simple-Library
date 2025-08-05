<?php

namespace App\Application\User;

use App\Application\User\DTO\UserCreateData;
use App\Application\User\DTO\UserUpdateData;
use App\Application\User\Exception\UserException;
use App\Application\User\Exception\UserValidationException;
use App\Application\User\Repository\UserRepositoryInterface;
use App\Application\User\Service\UserGetter;
use App\Application\User\Validator\UserCreateValidator;
use App\Application\User\Validator\UserUpdateValidator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

readonly class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserCreateValidator $createValidator,
        private UserUpdateValidator $updateValidator,
        private UserGetter          $getter,
    ) {}

    public function getOne(int $userId): ?User
    {
        return $this->userRepository->getOne($userId);
    }

    public function getOneByEmail(string $email): ?User
    {
        return $this->userRepository->getOneByEmail($email);
    }

    /**
     * @throws UserValidationException
     * @throws UserException
     */
    public function create(UserCreateData $data): User
    {
        $this->createValidator->validate($data);

        try {
            $user = User::create(
                [
                    'name'     => $data->getName(),
                    'email'    => $data->getEmail(),
                    'password' => Hash::make($data->getPassword()),
                ],
            );

            if ($data->getRole()) {
                $user->assignRole($data->getRole());
            }
        } catch (\Exception $exception) {
            throw new UserException($exception->getMessage());
        }

        return $user;
    }

    /**
     * @throws UserException
     * @throws UserValidationException
     */
    public function update(UserUpdateData $updateData): User
    {
        $this->updateValidator->validate($updateData);

        $user = $this->getter->get($updateData->getId());

        $data = [];

        if ($updateData->hasName()) {
            $data['name'] = $updateData->getName();
        }

        if ($updateData->hasEmail()) {
            $data['email'] = $updateData->getEmail();
        }

        if ($updateData->hasPassword()) {
            $data['password'] = Hash::make($updateData->getPassword());
        }

        try {
            $user->fill($data);
            $user->save();
        } catch (\Exception $exception) {
            throw new UserException($exception->getMessage(), $exception->getCode());
        }

        return $user;
    }
}
