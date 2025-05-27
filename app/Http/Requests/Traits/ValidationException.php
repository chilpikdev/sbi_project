<?php

namespace App\Http\Requests\Traits;

use App\Exceptions\ApiValidationException;
use Illuminate\Contracts\Validation\Validator;

trait ValidationException
{
    /**
     * Failed Validation Exception
     *
     * @override
     *
     * @throws \App\Exceptions\ApiValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new ApiValidationException($validator);
    }
}
