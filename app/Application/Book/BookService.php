<?php

namespace App\Application\Book;

use App\Application\Book\DTO\BookCreateData;
use App\Application\Book\DTO\BookUpdateData;
use App\Application\Book\Enum\BookTypeEnum;
use App\Application\Book\Exception\BookException;
use App\Application\Book\Exception\BookValidationException;
use App\Application\Book\Repository\BookRepositoryInterface;
use App\Application\Book\Repository\Contract\BookBySearchFilterDataInterface;
use App\Application\Book\Service\BookGetter;
use App\Application\Book\Validator\BookCreateValidator;
use App\Application\Book\Validator\BookUpdateValidator;
use App\Application\BookGenre\BookGenreService;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\MassAssignmentException;

readonly class BookService
{
    public function __construct(
        private BookRepositoryInterface $repository,
        private BookGetter              $getter,
        private BookCreateValidator     $createValidator,
        private BookUpdateValidator     $updateValidator,
        private BookGenreService        $bookGenreService,
    ) {}

    public function getById(int $id): ?Book
    {
        return $this->repository->getOne($id);
    }

    public function getBySearchFilter(BookBySearchFilterDataInterface $searchFilterData): Collection
    {
        return $this->repository->getBySearchFilter($searchFilterData);
    }

    /**
     * @throws BookValidationException
     * @throws BookException
     */
    public function create(BookCreateData $createData): Book
    {
        $this->createValidator->validate($createData);

        try {
            $book = Book::create(
                [
                    'author_id'      => $createData->getAuthorId(),
                    'title'          => $createData->getTitle(),
                    'type'           => BookTypeEnum::from($createData->getType()),
                    'published_year' => $createData->getPublishedYear(),
                    'description'    => $createData->getDescription(),
                ],
            );

            $this->bookGenreService->sync($book->id, $createData->getGenres());
        } catch (\Exception $exception) {
            throw new BookException($exception->getMessage(), $exception->getCode());
        }

        return $book;
    }

    /**
     * @throws BookValidationException
     * @throws BookException
     */
    public function update(BookUpdateData $updateData): Book
    {
        $this->updateValidator->validate($updateData);

        $book = $this->getter->get($updateData->getId());

        $data = [];

        if ($updateData->hasAuthorId()) {
            $data['author_id'] = $updateData->getAuthorId();
        }

        if ($updateData->hasTitle()) {
            $data['title'] = $updateData->getTitle();
        }

        if ($updateData->hasType()) {
            $data['type'] = BookTypeEnum::from($updateData->getType());
        }

        if ($updateData->hasPublishedYear()) {
            $data['publishedYear'] = $updateData->getPublishedYear();
        }

        if ($updateData->hasDescription()) {
            $data['description'] = $updateData->getDescription();
        }

        try {
            if ($updateData->hasGenres()) {
                $this->bookGenreService->sync($book->id, $updateData->getGenres());
            }

            $book->fill($data);
            $book->save();
        } catch (MassAssignmentException|\Exception $exception) {
            throw new BookException($exception->getMessage(), $exception->getCode());
        }

        return $book;
    }

    /**
     * @throws BookException
     */
    public function delete(int $id): void
    {
        $book = $this->getter->get($id);

        $book->delete();
    }
}
