<?php

namespace App\Http\Requests\Admin\Product;

use App\Contracts\Request\RequestContract;
use App\Http\Requests\Traits\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest implements RequestContract
{
    use ValidationException;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'per_page' => 'nullable|integer|max:100',
            'page' => 'nullable|int',
            'search' => 'nullable|string|min:2|max:255',
            'order_by' => 'nullable|string|min:1|max:100',
            'sort' => 'nullable|string|required_with:order_by|in:asc,desc',
            'category_id' => 'nullable|integer|exists:categories,id'
        ];
    }
}
