<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'name' => 'required|min:3|max:40',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|min:16',
            'password_confirm' => 'required|same:password',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp'
        ];
    }
}
