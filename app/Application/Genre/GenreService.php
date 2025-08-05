<?php

namespace App\Application\Genre;

use App\Application\Genre\DTO\GenreCreateData;
use App\Application\Genre\DTO\GenreUpdateData;
use App\Application\Genre\Exception\GenreException;
use App\Application\Genre\Exception\GenreValidationException;
use App\Application\Genre\Repository\GenreRepositoryInterface;
use App\Application\Genre\Repository\Contract\GenreBySearchFilterDataInterface;
use App\Application\Genre\Validator\GenreCreateValidator;
use App\Application\Genre\Validator\GenreUpdateValidator;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\MassAssignmentException;

readonly class GenreService
{
    public function __construct(
        private GenreRepositoryInterface $genreRepository,
        private GenreCreateValidator     $createValidator,
        private GenreUpdateValidator     $updateValidator,
    ) {}

    public function getById(int $id): ?Genre
    {
        return $this->genreRepository->getOne($id);
    }

    public function getBySearchFilter(GenreBySearchFilterDataInterface $searchFilterData): Collection
    {
        return $this->genreRepository->getBySearchFilter($searchFilterData);
    }

    public function getWithBookCountBySearchFilter(GenreBySearchFilterDataInterface $searchFilterData): Collection
    {
        return $this->genreRepository->getWithBookCountBySearchFilter($searchFilterData);
    }

    /**
     * @throws GenreValidationException
     * @throws GenreException
     */
    public function create(GenreCreateData $createData): Genre
    {
        $this->createValidator->validate($createData);

        try {
            $genre = Genre::create(
                [
                    'name' => $createData->getName(),
                ],
            );
        } catch (MassAssignmentException $exception) {
            throw new GenreException($exception->getMessage());
        }

        return $genre;
    }

    /**
     * @throws GenreException
     * @throws GenreValidationException
     */
    public function update(GenreUpdateData $updateData): Genre
    {
        $this->updateValidator->validate($updateData);

        $genre = $this->genreRepository->getOne($updateData->getId());

        if (!$genre) {
            throw new GenreException('Genre not found');
        }

        $data = [];

        if ($updateData->hasName()) {
            $data['name'] = $updateData->getName();
        }

        try {
            $genre->fill($data);
            $genre->save();
        } catch (MassAssignmentException $exception) {
            throw new GenreException($exception->getMessage(), $exception->getCode());
        }

        return $genre;
    }

    /**
     * @throws GenreException
     */
    public function delete(int $id): void
    {
        $genre = $this->genreRepository->getOne($id);

        if (!$genre) {
            throw new GenreException('Genre not found');
        }

        $genre->delete();
    }
}
