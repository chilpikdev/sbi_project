<?php

namespace App\Services\Admin;

use App\DTO\Admin\Category\IndexDto;
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
}
