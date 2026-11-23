<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscountCodeRequest extends FormRequest
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
        $discountCodeId = $this->route('discountCode')?->id;
        return [
            'code'                => [
                'required', 'string', 'max:50',
                Rule::unique('discount_codes', 'code')->ignore($discountCodeId),
            ],
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'percentage'          => 'required|numeric|min:1|max:100',
            'max_discount_limit'  => 'required|numeric|min:0',
            'usage_limit'         => 'required|integer|min:1',
            'is_once'             => 'boolean',
            'is_active'           => 'boolean',
        ];
    }
}
