<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VariantRequest extends FormRequest
{
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // size , unit , price , quantity , limit
        return [
            'product_size_id' => 'required|exists:product_sizes,id',
            'unit_id' => 'required|exists:product_units,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'product_limit' => 'nullable|integer|min:1',
            'sale_ids' => ['nullable', 'array'],
            'sale_ids.*' => ['integer', 'exists:sales,id'],
        ];
    }
}
