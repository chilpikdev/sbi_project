<?php

namespace App\Repositories\Admin;

use App\DTO\Admin\Category\IndexDto;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryRepository
{
    /**
     * Summary of paginateWithFilters
     * @param \App\DTO\Admin\Category\IndexDto $dto
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginateWithFilters(IndexDto $dto): LengthAwarePaginator
    {
        $query = Category::query();

        if ($dto->search) {
            $query->where('name', 'ILIKE', "%{$dto->search}%");
        }

        match ($dto->orderBy) {
            'id', 'name', 'created_at' => $query->orderBy($dto->orderBy, $dto->sort),
            default => $query->orderBy('created_at', 'desc'),
        };

        return $query->paginate(
            perPage: $dto->perPage,
            page: $dto->page
        );
    }
}
