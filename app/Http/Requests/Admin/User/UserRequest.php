<?php

namespace App\Http\Requests\Admin\User;

use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->user_type === "admin";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'email' => ['required','email', Rule::unique('users')->ignore($this->id, 'id')],
            'number' => ['required', 'int', 'digits:10', Rule::unique('users')->ignore($this->id, 'id')],
            'user_type' => 'required',
            'status' => 'required',
        ];
        $this->method() == "POST" ? $rules['password'] = 'required|min:8' : $rules['password'] = 'nullable|min:8';
        return  $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter product name',
            'email.required' => 'Please enter a email address',
            'email.email' => 'Please enter a valid email address',
            'number.required' => 'Please enter a 10 digit mobile number',
            'number.int' => 'Please enter valid mobile number',
            'number.digits' => 'Please enter only 10 digit mobile number',
            'password.required' => 'Please enter a password',
            'password.min' => 'Please enter at least 8 characters',
            'user_type.min' => 'Please select user type',
            'status.required' => 'Please select product status',
            'login_type.required' => 'Please select login type',
            'login_access_until.required' => 'Please select login time'
        ];
    }
}
