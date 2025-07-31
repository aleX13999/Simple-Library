<?php

namespace App\Http\Controllers;

use App\Application\Book\BookService;
use App\Application\Book\DTO\BookCreateData;
use App\Application\Book\DTO\BookUpdateData;
use App\Application\Book\Exception\BookException;
use App\Application\Book\Exception\BookValidationException;
use App\Application\BookGenre\Exception\BookGenreException;
use App\Http\Requests\Book\BookCreateRequest;
use App\Http\Requests\Book\BookListRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Repositories\Data\Book\DTO\BookBySearchFilterData;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function __construct(
        private readonly BookService $bookService,
    ) {}

    public function index(BookListRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $data = new BookBySearchFilterData();
        $data
            ->setSkip($validated['skip'] ?? null)
            ->setTake($validated['take'] ?? null);

        $books = $this->bookService->getBySearchFilter($data);

        return new JsonResponse(['data' => BookResource::collection($books)]);
    }

    public function store(BookCreateRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $createData = new BookCreateData();
        $createData
            ->setAuthorId($validated['authorId'])
            ->setTitle($validated['title'])
            ->setType($validated['type'])
            ->setPublishedYear($validated['publishedYear'] ?? null)
            ->setDescription($validated['description'] ?? null)
            ->setGenres($validated['genre_ids'] ?? null);

        try {
            $book = $this->bookService->create($createData);

        } catch (BookValidationException $exception) {
            return new JsonResponse(['errors' => $exception->getMessage()], 422);

        } catch (BookException $exception) {
            if ($exception->getCode() === BookGenreException::SYNC_ERROR) {
                return new JsonResponse(['errors' => $exception->getMessage()], 400);
            }

            return new JsonResponse(['errors' => $exception->getMessage()], 404);
        }

        return new JsonResponse(['data' => new BookResource($book)], 201);
    }

    public function show(string $id): JsonResponse
    {
        return new JsonResponse(['data' => new BookResource($this->bookService->getById($id))]);
    }

    public function update(BookUpdateRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();

        $updateData = new BookUpdateData($id);

        if (isset($validated['authorId'])) {
            $updateData->setAuthorId($validated['authorId']);
        }

        if (isset($validated['title'])) {
            $updateData->setTitle($validated['title']);
        }

        if (isset($validated['type'])) {
            $updateData->setType($validated['type']);
        }

        if (array_key_exists('publishedYear', $validated)) {
            $updateData->setPublishedYear($validated['publishedYear']);
        }

        if (array_key_exists('description', $validated)) {
            $updateData->setDescription($validated['description']);
        }

        if (array_key_exists('genre_ids', $validated)) {
            $updateData->setGenres($validated['genre_ids']);
        }

        try {
            $book = $this->bookService->update($updateData);
        } catch (BookValidationException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 422);
        } catch (BookException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 404);
        }

        return new JsonResponse(['data' => new BookResource($book)]);
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $this->bookService->delete($id);
        } catch (BookException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 404);
        }

        return new JsonResponse(['success' => true]);
    }
}
