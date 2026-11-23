<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends FormRequest
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
            'first_name'    => 'required|string|max:50',
            'last_name'     => 'required|string|max:50',
            'phone'         => 'nullable|string|max:20|unique:users,phone',
            'email'         => 'required|email|unique:users,email',
            'gender'        => ['nullable',new Enum(Gender::class)],
            'password'      => 'required|string|min:8|confirmed',
            'date_of_birth' => 'nullable|date',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
