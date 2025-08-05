<?php

namespace App\Http\Controllers\Api\Author;

use App\Application\Author\AuthorService;
use App\Application\Author\DTO\AuthorUpdateData;
use App\Application\Author\Exception\AuthorException;
use App\Application\User\DTO\UserUpdateData;
use App\Application\User\Exception\UserException;
use App\Application\User\Exception\UserValidationException;
use App\Application\User\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Author\AuthorUpdateProfileRequest;
use App\Http\Resources\Author\AuthorResource;
use Illuminate\Http\JsonResponse;

class AuthorProfileController extends Controller
{
    public function __construct(
        private readonly UserService   $userService,
        private readonly AuthorService $authorService,
    ) {}

    public function update(AuthorUpdateProfileRequest $request): JsonResponse
    {
        $user   = $request->user();
        $author = $user->author;

        $validated = $request->validated();

        $userUpdatedData = new UserUpdateData($user->id);

        if (array_key_exists('name', $validated)) {
            $userUpdatedData->setName($validated['name']);
        }

        if (array_key_exists('email', $validated)) {
            $userUpdatedData->setEmail($validated['email']);
        }

        if (array_key_exists('password', $validated)) {
            $userUpdatedData->setPassword($validated['password']);
        }

        $authorUpdateData = new AuthorUpdateData($author->id);

        if (array_key_exists('firstName', $validated)) {
            $authorUpdateData->setFirstName($validated['firstName']);
        }

        if (array_key_exists('lastName', $validated)) {
            $authorUpdateData->setLastName($validated['lastName']);
        }

        if (array_key_exists('patronymic', $validated)) {
            $authorUpdateData->setPatronymic($validated['patronymic']);
        }

        try {
            $this->userService->update($userUpdatedData);

            $author = $this->authorService->update($authorUpdateData);
        } catch (UserException|AuthorException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        } catch (UserValidationException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 422);
        }

        return new JsonResponse(['data' => new AuthorResource($author)], 200);
    }
}
