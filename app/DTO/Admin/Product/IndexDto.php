<?php

namespace App\DTO\Admin\Product;

use App\Contracts\Request\RequestContract;
use App\DTO\BaseIndexDto;

readonly class IndexDto extends BaseIndexDto
{
    public function __construct(
        ?int $perPage,
        ?int $page,
        ?string $search,
        ?string $orderBy,
        ?string $sort,
        public ?int $categoryId,
    ) {
        parent::__construct(
            perPage: $perPage,
            page: $page,
            search: $search,
            orderBy: $orderBy,
            sort: $sort
        );
    }

    #[\Override]
    public static function from(RequestContract $request): self
    {
        return new self(
            perPage: $request->get('per_page'),
            page: $request->get('page'),
            search: $request->get('search'),
            orderBy: $request->get('order_by'),
            sort: $request->get('sort'),
            categoryId: $request->get('category_id'),
        );
    }
}
