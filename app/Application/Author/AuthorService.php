<?php

namespace App\Application\Author;

use App\Application\Author\DTO\AuthorCreateData;
use App\Application\Author\DTO\AuthorUpdateData;
use App\Application\Author\Exception\AuthorException;
use App\Application\Author\Repository\AuthorRepositoryInterface;
use App\Application\Author\Repository\Contract\AuthorBySearchFilterDataInterface;
use App\Application\Author\Service\AuthorGetter;
use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

readonly class AuthorService
{
    public function __construct(
        private AuthorRepositoryInterface $repository,
        private AuthorGetter              $getter,
    ) {}

    public function getById(int $id): ?Author
    {
        return $this->repository->getOne($id);
    }

    public function getBySearchFilter(AuthorBySearchFilterDataInterface $searchFilterData): Collection
    {
        return $this->repository->getBySearchFilter($searchFilterData);
    }

    /**
     * @throws AuthorException
     */
    public function create(AuthorCreateData $createData): Author
    {
        try {
            return Author::create(
                [
                    'first_name' => $createData->getFirstName(),
                    'last_name'  => $createData->getLastName(),
                    'patronymic' => $createData->getPatronymic(),
                ],
            );
        } catch (\Exception $exception) {
            throw new AuthorException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @throws AuthorException
     */
    public function update(AuthorUpdateData $updateData): Author
    {
        $author = $this->getter->get($updateData->getId());

        $data = [];

        if ($updateData->hasFirstName()) {
            $data['first_name'] = $updateData->getFirstName();
        }

        if ($updateData->hasLastName()) {
            $data['last_name'] = $updateData->getLastName();
        }

        if ($updateData->hasPatronymic()) {
            $data['patronymic'] = $updateData->getPatronymic();
        }

        try {
            $author->fill($data);
            $author->save();
        } catch (\Exception $exception) {
            throw new AuthorException($exception->getMessage(), $exception->getCode());
        }

        return $author;
    }

    /**
     * @throws AuthorException
     */
    public function delete(int $id): void
    {
        $author = $this->getter->get($id);

        $author->delete();
    }
}
