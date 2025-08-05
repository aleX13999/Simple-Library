<?php

namespace App\Http\Controllers\Api;

use App\Application\Author\AuthorService;
use App\Application\Author\Exception\AuthorException;
use App\Application\Book\BookService;
use App\Application\Book\Exception\BookException;
use App\Application\Genre\GenreService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Author\AuthorListRequest;
use App\Http\Requests\Book\BookListRequest;
use App\Http\Requests\Genre\GenreListRequest;
use App\Http\Resources\Author\AuthorWithBooksResource;
use App\Http\Resources\Book\BookResource;
use App\Http\Resources\Book\BookWithAuthorNameResource;
use App\Http\Resources\Genre\GenreWithBookCountResource;
use App\Repositories\Data\Author\DTO\AuthorBySearchFilterData;
use App\Repositories\Data\Book\DTO\BookBySearchFilterData;
use App\Repositories\Data\Genre\DTO\GenreBySearchFilterData;
use Illuminate\Http\JsonResponse;

class PublicApiController extends Controller
{
    public function __construct(
        private readonly AuthorService $authorService,
        private readonly BookService   $bookService,
        private readonly GenreService  $genreService,
    ) {}

    public function authors(AuthorListRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $data = new AuthorBySearchFilterData();
        $data
            ->setSkip($validated['skip'] ?? null)
            ->setTake($validated['take'] ?? null);

        $authors = $this->authorService->getBySearchFilter($data);

        return new JsonResponse(['data' => AuthorWithBooksResource::collection($authors)]);
    }

    public function author(string $id): JsonResponse
    {
        try {
            $author = $this->authorService->get($id);
        } catch (AuthorException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 404);
        }

        return new JsonResponse(['data' => new AuthorWithBooksResource($author)]);
    }

    public function books(BookListRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $data = new BookBySearchFilterData();
        $data
            ->setSkip($validated['skip'] ?? null)
            ->setTake($validated['take'] ?? null);

        $books = $this->bookService->getBySearchFilter($data);

        return new JsonResponse(['data' => BookWithAuthorNameResource::collection($books)]);
    }

    public function book(string $id): JsonResponse
    {
        try {
            $book = $this->bookService->get($id);
        } catch (BookException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 404);
        }

        return new JsonResponse(['data' => new BookResource($book)]);
    }

    public function genres(GenreListRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $data = new GenreBySearchFilterData();
        $data
            ->setSkip($validated['skip'] ?? null)
            ->setTake($validated['take'] ?? null);

        $genres = $this->genreService->getWithBookCountBySearchFilter($data);

        return new JsonResponse(['data' => GenreWithBookCountResource::collection($genres)]);
    }
}
