<?php

namespace App\Http\Requests;

use App\Enums\BuildingType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AddressRequest extends FormRequest
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
        $required = $this->isMethod('POST') ? ['required'] : ['sometimes', 'required'];

        return [
            'nickname'     => 'nullable|string|max:50',
            'phone'        => 'nullable|string|max:20',
            'governate'    => [...$required, 'string', 'max:50'],
            'type'         => [...$required, new Enum(BuildingType::class)],
            'building'     => 'nullable|string|max:20',
            'floor'        => 'nullable|integer',
            'apartment'    => 'nullable|string|max:10',
            'details'      => 'nullable|string',
            'neighborhood' => 'nullable|string|max:100',
            'is_main'      => 'boolean',
            'is_active'    => 'boolean',
        ];
    }
}
