<?php

namespace App\Http\Requests\Product;

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
            'name' => 'required|max:255',
            'description' => 'required',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'points_price' => 'required|numeric|min:0',
            'cash_equivalent' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'is_available' => 'required|boolean',
            'category_id' => 'required|exists:product_categories,id',
        ];
    }
}