<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        return [
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'quantity' => 'required|min:1|int',
            'price' => 'required|min:1|int',
            'main_image' => Rule::requiredIf(function (){
                if (Product::whereId($this->id)->whereNotNull('main_image')->exists()) {
                    return false;
                }
                return true;
            }),
            'images' => Rule::requiredIf(function (){
                if (ProductImage::whereProductId($this->id)->exists()) {
                    return false;
                }
                return true;
            }),
            'slug' => ['required', Rule::unique('products', 'slug')->ignore($this->id, 'id')],
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
            'name.required' => 'Please enter product name',
            'description.required' => 'Please enter product description',
            'category_id.required' => 'Please select product category',
            'quantity.required' => 'Please enter product box quantity',
            'quantity.min' => 'Please enter product quantity greater then 1',
            'images.required' => 'Please upload product images',
            'status.required' => 'Please select product status'
        ];
    }
}
