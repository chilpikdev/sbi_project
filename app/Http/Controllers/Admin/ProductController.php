<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Admin\Product\CreateDto;
use App\DTO\Admin\Product\IndexDto;
use App\DTO\Admin\Product\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateRequest;
use App\Http\Requests\Admin\Product\IndexRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Http\Resources\Admin\Product\ProductResource;
use App\Services\Admin\ProductService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    use ResponseTrait;

    public function __construct(
        protected ProductService $service
    ) {
    }

    /**
     * Summary of index
     * @param \App\Http\Requests\Admin\Product\IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        $items = $this->service->getPaginatedList(IndexDto::from($request));

        return static::toResponse(
            data: ProductResource::collection($items)
        );
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\Admin\Product\CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request): JsonResponse
    {
        $item = $this->service->create(CreateDto::from($request));

        return static::toResponse(
            code: 201,
            message: 'Product created',
            data: new ProductResource($item)
        );
    }

    /**
     * Summary of show
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $item = $this->service->find($id);

        return static::toResponse(
            data: new ProductResource($item)
        );
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Admin\Product\UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $item = $this->service->update($id, UpdateDto::from($request));

        return static::toResponse(
            message: 'Product updated',
            data: new ProductResource($item)
        );
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);

        return static::toResponse(
            message: 'Product deleted',
        );
    }
}
