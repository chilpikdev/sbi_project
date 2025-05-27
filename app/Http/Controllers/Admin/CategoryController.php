<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Admin\Category\IndexDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\IndexRequest;
use App\Http\Resources\Admin\Category\IndexResource;
use App\Services\Admin\CategoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        return $this->toResponse(
            data: IndexResource::collection($items)
        );
    }

    public function create()
    {
        
    }
}
