<?php

namespace App\DTO\Admin\Product;

use App\Contracts\Request\RequestContract;
use App\DTO\BaseDto;

readonly class UpdateDto extends BaseDto
{
    public function __construct(
        public string $name,
        public float $price,
        public string $barcode,
        public int $categoryId,
    ) {
    }

    #[\Override]
    public static function from(RequestContract $request): self
    {
        return new self(
            name: $request->get('name'),
            price: $request->get('price'),
            barcode: $request->get('barcode'),
            categoryId: $request->get('category_id'),
        );
    }
}
