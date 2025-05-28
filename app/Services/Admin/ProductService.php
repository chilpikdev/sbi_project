<?php

namespace App\Services\Admin;

use App\DTO\Admin\Product\CreateDto;
use App\DTO\Admin\Product\IndexDto;
use App\DTO\Admin\Product\UpdateDto;
use App\Models\Product;
use App\Repositories\Admin\ProductRepository;
use App\Traits\CacheTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    use CacheTrait;

    public function __construct(
        protected ProductRepository $repository
    ) {
    }

    /**
     * Summary of getPaginatedList
     * @param \App\DTO\Admin\Product\IndexDto $dto
     * @return mixed
     */
    public function getPaginatedList(IndexDto $dto): mixed
    {
        return $this->remember(
            key: 'products',
            callback: fn (): LengthAwarePaginator => $this->repository->paginateWithFilters($dto)
        );
    }

    /**
     * Summary of create
     * @param \App\DTO\Admin\Product\CreateDto $dto
     * @return Product
     */
    public function create(CreateDto $dto): Product
    {
        return $this->repository->create($dto);
    }

    /**
     * Summary of find
     * @param int $id
     * @return Product
     */
    public function find(int $id): Product
    {
        return $this->repository->findById($id);
    }

    /**
     * Summary of update
     * @param int $id
     * @param \App\DTO\Admin\Product\UpdateDto $dto
     * @return Product
     */
    public function update(int $id, UpdateDto $dto): Product
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
