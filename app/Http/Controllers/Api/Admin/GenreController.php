<?php

namespace App\Http\Controllers\Api\Admin;

use App\Application\Genre\DTO\GenreCreateData;
use App\Application\Genre\DTO\GenreUpdateData;
use App\Application\Genre\Exception\GenreException;
use App\Application\Genre\Exception\GenreValidationException;
use App\Application\Genre\GenreService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Genre\GenreCreateRequest;
use App\Http\Requests\Genre\GenreListRequest;
use App\Http\Requests\Genre\GenreUpdateRequest;
use App\Http\Resources\Genre\GenreResource;
use App\Repositories\Data\Genre\DTO\GenreBySearchFilterData;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
    public function __construct(
        private readonly GenreService $genreService,
    ) {}

    public function index(GenreListRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $data = new GenreBySearchFilterData();
        $data
            ->setSkip($validated['skip'] ?? null)
            ->setTake($validated['take'] ?? null);

        $genres = $this->genreService->getBySearchFilter($data);

        return new JsonResponse(['data' => GenreResource::collection($genres)]);
    }

    public function store(GenreCreateRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $creteData = new GenreCreateData();
        $creteData
            ->setName($validated['name']);

        try {
            $genre = $this->genreService->create($creteData);
        } catch (GenreValidationException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 422);
        } catch (GenreException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse(['data' => new GenreResource($genre)]);
    }

    public function show(string $id): JsonResponse
    {
        return new JsonResponse(['data' => new GenreResource($this->genreService->getById($id))]);
    }

    public function update(GenreUpdateRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();

        $updateData = new GenreUpdateData($id);

        if (isset($validated['name'])) {
            $updateData->setName($validated['name']);
        }

        try {
            $genre = $this->genreService->update($updateData);
        } catch (GenreException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 404);
        } catch (GenreValidationException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 422);
        }

        return new JsonResponse(['data' => new GenreResource($genre)]);
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $this->genreService->delete($id);
        } catch (GenreException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()]);
        }

        return new JsonResponse(['success' => true]);
    }
}
