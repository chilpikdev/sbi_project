<?php

namespace App\DTO\Admin\Category;

use App\Contracts\Request\RequestContract;
use App\DTO\BaseDto;

readonly class UpdateDto extends BaseDto
{
    public function __construct(
        public string $name,
    ) {
    }

    #[\Override]
    public static function from(RequestContract $request): self
    {
        return new self(
            name: $request->get('name'),
        );
    }
}
