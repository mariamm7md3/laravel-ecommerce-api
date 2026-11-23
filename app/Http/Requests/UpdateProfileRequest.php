<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        return [
            'first_name'    => 'sometimes|string|max:50',
            'last_name'     => 'sometimes|string|max:50',
            'phone'         => 'sometimes|string|max:20',
            'gender'        => 'sometimes|in:Male,Female',
            'date_of_birth' => 'sometimes|date',
            'photo'         => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
