<?php

namespace App\Http\Controllers\Api\Admin;

use App\Application\Author\AuthorService;
use App\Application\Author\DTO\AuthorCreateData;
use App\Application\Author\DTO\AuthorUpdateData;
use App\Application\Author\Exception\AuthorException;
use App\Application\Author\Exception\AuthorValidationException;
use App\Application\User\DTO\UserCreateData;
use App\Application\User\Exception\UserException;
use App\Application\User\Exception\UserValidationException;
use App\Application\User\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Author\AuthorCreateRequest;
use App\Http\Requests\Author\AuthorListRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Http\Resources\Author\AuthorResource;
use App\Repositories\Data\Author\DTO\AuthorBySearchFilterData;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    public function __construct(
        private readonly AuthorService $authorService,
        private readonly UserService   $userService,
    ) {}

    public function index(AuthorListRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $data = new AuthorBySearchFilterData();
        $data
            ->setSkip($validated['skip'] ?? null)
            ->setTake($validated['take'] ?? null);

        $authors = $this->authorService->getBySearchFilter($data);

        return new JsonResponse(['data' => AuthorResource::collection($authors)]);
    }

    public function store(AuthorCreateRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $userCreateData = new UserCreateData();
        $userCreateData
            ->setName($validated['name'])
            ->setEmail($validated['email'])
            ->setPassword($validated['password'])
            ->setRole('author');

        try {
            $user = $this->userService->create($userCreateData);

            $authorCreateData = new AuthorCreateData();
            $authorCreateData
                ->setUserId($user->id)
                ->setFirstName($validated['firstName'])
                ->setLastName($validated['lastName'])
                ->setPatronymic($validated['patronymic'] ?? null);

            $author = $this->authorService->create($authorCreateData);
        } catch (UserValidationException|AuthorValidationException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 422);
        } catch (UserException|AuthorException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse(['data' => new AuthorResource($author)], 201);
    }

    public function show(string $id): JsonResponse
    {
        return new JsonResponse(['data' => new AuthorResource($this->authorService->getById($id))]);
    }

    public function update(AuthorUpdateRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();

        $updateData = new AuthorUpdateData($id);

        if (isset($validated['firstName'])) {
            $updateData->setFirstName($validated['firstName']);
        }

        if (isset($validated['lastName'])) {
            $updateData->setLastName($validated['lastName']);
        }

        if (array_key_exists('patronymic', $validated)) {
            $updateData->setPatronymic($validated['patronymic']);
        }

        try {
            $author = $this->authorService->update($updateData);
        } catch (AuthorException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 404);
        }

        return new JsonResponse(['data' => new AuthorResource($author)]);
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $this->authorService->delete($id);
        } catch (AuthorException $exception) {
            return new JsonResponse(['data' => $exception->getMessage()]);
        }

        return new JsonResponse(['success' => true]);
    }
}
