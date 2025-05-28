<?php

namespace App\Repositories\Admin;

use App\DTO\Admin\Product\CreateDto;
use App\DTO\Admin\Product\IndexDto;
use App\DTO\Admin\Product\UpdateDto;
use App\Exceptions\ApiErrorException;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRepository
{
    /**
     * Summary of paginateWithFilters
     * @param \App\DTO\Admin\Product\IndexDto $dto
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginateWithFilters(IndexDto $dto): LengthAwarePaginator
    {
        $query = Product::with('category');

        if ($dto->categoryId) {
            $query->where('category_id', $dto->categoryId);
        }

        if ($dto->search) {
            $query->where('name', 'ILIKE', "%{$dto->search}%");
        }

        match ($dto->orderBy) {
            'id', 'name', 'price', 'barcode', 'created_at' => $query->orderBy($dto->orderBy, $dto->sort),
            'category_id' => $query
                ->leftJoin('categories', $query->getModel()->getTable() . '.branch_id', '=', 'categories.id')
                ->select($query->getModel()->getTable() . '.*')
                ->orderBy('categories.name', $dto->sort),
            default => $query->orderBy('created_at', 'desc'),
        };

        return $query->paginate(
            perPage: $dto->perPage,
            page: $dto->page
        );
    }

    /**
     * Summary of create
     * @param \App\DTO\Admin\Product\CreateDto $dto
     * @return Product
     */
    public function create(CreateDto $dto): Product
    {
        return Product::create([
            'name' => $dto->name,
            'price' => $dto->price,
            'barcode' => $dto->barcode,
            'category_id' => $dto->categoryId,
        ]);
    }

    /**
     * Summary of findById
     * @param int $id
     * @return Product
     */
    public function findById(int $id): Product
    {
        try {
            return Product::findOrFail($id);
        } catch (ModelNotFoundException $ex) {
            throw new ApiErrorException(404, 'Product not found');
        }
    }

    /**
     * Summary of update
     * @param \App\Models\Product $product
     * @param \App\DTO\Admin\Product\UpdateDto $dto
     * @return Product
     */
    public function update(Product $product, UpdateDto $dto): Product
    {
        $product->update([
            'name' => $dto->name,
            'price' => $dto->price,
            'barcode' => $dto->barcode,
            'category_id' => $dto->categoryId,
        ]);

        return $product;
    }

    /**
     * Summary of delete
     * @param \App\Models\Product $product
     * @return void
     */
    public function delete(Product $product): void
    {
        $product->delete();
    }
}
