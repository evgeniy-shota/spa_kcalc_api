<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'category_id' => 'nullable|array',
            // 'type_id' => 'nullable|integer',
            'is_personal' => 'nullable|boolean',
            'is_abstract' => 'nullable|boolean',
            'is_favorite' => 'nullable|boolean',
            'is_hidden' => 'nullable|boolean',
            'name' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|array',
            'country_of_manufacture' => 'nullable|array',

            // 'trademark_id' => 'nullable|integer',
            // 'units' => 'nullable|',
            // 'condition' => 'nullable|',

            // 'state' => 'nullable|',
            'quantity' => 'nullable|array',
            // 'composition' => 'nullable|',
            'kcalory' => 'nullable|array',
            'proteins' => 'nullable|array',
            'carbohydrates' => 'nullable|array',
            'fats' => 'nullable|array',
            // 'nutrients_and_vitamins' => 'nullable|',
            // 'data_source' => 'nullable|',
        ];
    }
}
