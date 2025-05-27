<?php

namespace App\Services\Admin;

use App\DTO\Admin\Category\CreateDto;
use App\DTO\Admin\Category\IndexDto;
use App\DTO\Admin\Category\UpdateDto;
use App\Models\Category;
use App\Repositories\Admin\CategoryRepository;
use App\Traits\CacheTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService
{
    use CacheTrait;

    public function __construct(
        protected CategoryRepository $repository
    ) {
    }

    /**
     * Summary of getPaginatedList
     * @param \App\DTO\Admin\Category\IndexDto $dto
     * @return mixed
     */
    public function getPaginatedList(IndexDto $dto): mixed
    {
        return $this->remember(
            key: 'categories',
            callback: fn (): LengthAwarePaginator => $this->repository->paginateWithFilters($dto)
        );
    }

    /**
     * Summary of create
     * @param \App\DTO\Admin\Category\CreateDto $dto
     * @return Category
     */
    public function create(CreateDto $dto): Category
    {
        return $this->repository->create($dto);
    }

    /**
     * Summary of find
     * @param int $id
     * @return Category
     */
    public function find(int $id): Category
    {
        return $this->repository->findById($id);
    }

    /**
     * Summary of update
     * @param int $id
     * @param \App\DTO\Admin\Category\UpdateDto $dto
     * @return Category
     */
    public function update(int $id, UpdateDto $dto): Category
    {
        $item = $this->repository->findById($id);

        return $this->repository->update($item, $dto);
    }

    /**
     * Summary of delete
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $item = $this->repository->findById($id);

        $this->repository->delete($item);
    }
}
