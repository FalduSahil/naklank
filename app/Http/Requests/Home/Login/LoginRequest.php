<?php

namespace App\Http\Requests\Home\Login;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please enter a email address',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Please provide a password',
            'password.min' => 'Your password must be at least 8 characters long',
        ];
    }
}
