<?php

namespace App\Repositories\Admin;

use App\DTO\Admin\Category\CreateDto;
use App\DTO\Admin\Category\IndexDto;
use App\DTO\Admin\Category\UpdateDto;
use App\Exceptions\ApiErrorException;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    /**
     * Summary of create
     * @param \App\DTO\Admin\Category\CreateDto $dto
     * @return Category
     */
    public function create(CreateDto $dto): Category
    {
        return Category::create([
            'name' => $dto->name,
        ]);
    }

    /**
     * Summary of findById
     * @param int $id
     * @return Category
     */
    public function findById(int $id): Category
    {
        try {
            return Category::findOrFail($id);
        } catch (ModelNotFoundException $ex) {
            throw new ApiErrorException(404, 'Category not found');
        }
    }

    /**
     * Summary of update
     * @param \App\Models\Category $category
     * @param \App\DTO\Admin\Category\UpdateDto $dto
     * @return Category
     */
    public function update(Category $category, UpdateDto $dto): Category
    {
        $category->update([
            'name' => $dto->name,
        ]);

        return $category;
    }

    /**
     * Summary of delete
     * @param \App\Models\Category $category
     * @return void
     */
    public function delete(Category $category): void
    {
        $category->delete();
    }
}
