<?php

namespace App\Http\Requests\Home\Inquiry;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'message' => 'required',
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Please enter your first name',
            'last_name.required' => 'Please enter your last name',
            'phone.required' => 'Please enter your mobile number',
            'message.required' => 'Please enter your inquiry message',
            'email.required' => 'Please enter a email address',
            'email.email' => 'Please enter a valid email address',
        ];
    }
}
