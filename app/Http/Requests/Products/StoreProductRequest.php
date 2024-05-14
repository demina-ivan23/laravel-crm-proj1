<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'title' => 'required|string|max:225',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:1000000',
            'product_image' => 'nullable|mimes:img,jpg,jpeg,png|max:2000',
            'category' => 'string',
            'custom_category' => 'string|max:225'
        ];
    }
}
