<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Admin\Category\CreateDto;
use App\DTO\Admin\Category\IndexDto;
use App\DTO\Admin\Category\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateRequest;
use App\Http\Requests\Admin\Category\IndexRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Http\Resources\Admin\Category\CategoryResource;
use App\Services\Admin\CategoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    use ResponseTrait;

    public function __construct(
        protected CategoryService $service
    ) {
    }

    /**
     * Summary of index
     * @param \App\Http\Requests\Admin\Category\IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        $items = $this->service->getPaginatedList(IndexDto::from($request));

        return static::toResponse(
            data: CategoryResource::collection($items)
        );
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\Admin\Category\CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request): JsonResponse
    {
        $item = $this->service->create(CreateDto::from($request));

        return static::toResponse(
            code: 201,
            message: 'Category created',
            data: new CategoryResource($item)
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
            data: new CategoryResource($item)
        );
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Admin\Category\UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $item = $this->service->update($id, UpdateDto::from($request));

        return static::toResponse(
            message: 'Category updated',
            data: new CategoryResource($item)
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
            message: 'Category deleted',
        );
    }
}
