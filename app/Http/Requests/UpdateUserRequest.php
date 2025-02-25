<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|min:3|max:40',
            'email' => [
                'nullable',
                'email:rfc,dns',
                Rule::unique('users')->ignore($this->user()->id),
            ],
            'password' => 'nullable|min:16',
            'confirm_password' => 'nullable|same:password',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp'
        ];
    }
}
