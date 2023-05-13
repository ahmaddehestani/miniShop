<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required',
            'primary_image' => 'required|image',
            'description' => 'required',
            'price' => 'integer',
            'quantity' => 'integer',
            'delivery_amount' => 'integer',
            'images.*' => 'image'
        ];
    }
}
