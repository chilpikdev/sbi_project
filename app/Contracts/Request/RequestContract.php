<?php

namespace App\Contracts\Request;

interface RequestContract
{
    public function authorize(): bool;

    public function rules(): array;
}
