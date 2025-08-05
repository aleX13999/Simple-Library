<?php

namespace App\Http\Controllers\Api\Author;

use App\Application\Book\BookService;
use App\Application\Book\DTO\BookUpdateData;
use App\Application\Book\Exception\BookException;
use App\Application\Book\Exception\BookValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Author\AuthorBookUpdateRequest;
use App\Http\Resources\Book\BookResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class AuthorBookController extends Controller
{
    public function __construct(
        private readonly BookService $bookService,
    ) {}

    public function update(AuthorBookUpdateRequest $request, string $id): JsonResponse
    {
        try {
            $book = $this->bookService->get($id);

            $this->authorize('update', $book);

            $validated = $request->validated();

            $updateData = new BookUpdateData($id);

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

            $book = $this->bookService->update($updateData);

        } catch (BookException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 404);

        } catch (AuthorizationException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 403);

        } catch (BookValidationException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 422);
        }

        return new JsonResponse(['data' => new BookResource($book)]);
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $book = $this->bookService->get($id);

            $this->authorize('update', $book);

            $this->bookService->delete($id);

        } catch (BookException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 404);

        } catch (AuthorizationException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 403);
        }

        return new JsonResponse(['success' => true]);
    }
}
