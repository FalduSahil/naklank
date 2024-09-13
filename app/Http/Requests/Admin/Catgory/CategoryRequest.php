<?php

namespace App\Http\Requests\Admin\Catgory;

use App\Models\Category;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

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
        return [
            'name' => 'required',
            'description' => 'required',
            'slug' => ['required', Rule::unique('categories', 'slug')->ignore($this->id, 'id')],
            'image' => Rule::requiredIf(function (){
                if (Category::whereId($this->id)->whereNotNull('image')->exists()) {
                    return false;
                }
                return true;
            }),
            'status' => 'required'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->slug, '-'),
        ]);
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter name',
            'description.required' => 'Please enter description',
            'status.required' => 'Please select status',
            'image.required' => 'Please upload a image',
        ];
    }
}
