<?php

namespace App\DTO;

use App\Contracts\Request\RequestContract;

abstract readonly class BaseDto
{
    /**
     * Summary of from
     * @param \App\Contracts\Request\RequestContract $request
     * @return void
     */
    abstract static function from(RequestContract $request): self;
}
