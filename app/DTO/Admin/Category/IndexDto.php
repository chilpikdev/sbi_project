<?php

namespace App\DTO\Admin\Category;

use App\Contracts\Request\RequestContract;
use App\DTO\BaseIndexDto;

readonly class IndexDto extends BaseIndexDto
{
    #[\Override]
    public static function from(RequestContract $request): self
    {
        return new self(
            perPage: $request->get('per_page'),
            page: $request->get('page'),
            search: $request->get('search'),
            orderBy: $request->get('order_by'),
            sort: $request->get('sort'),
        );
    }
}
