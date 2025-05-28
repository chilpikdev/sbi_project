<?php

namespace App\Http\Requests\Admin\Product;

use App\Contracts\Request\RequestContract;
use App\Http\Requests\Traits\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest implements RequestContract
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
            'name' => 'required|string|min:2',
            'price' => 'required|numeric|min:0',
            'barcode' => 'required|string|max_digits:13|min_digits:13|unique:products,barcode',
            'category_id' => 'required|integer|exists:categories,id'
        ];
    }
}
