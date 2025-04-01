<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'category_id' => 'numeric|integer|required',
            // 'user_id' => 'numeric|integer|required',
            'is_personal' => 'boolean|nullable',
            'is_enabled' => 'boolean|nullable',
            'is_abstract' => 'boolean|nullable',
            'name' => 'string|required',
            'thumbnail_image_name' => 'string|nullable',
            'manufacturer_id' => 'numeric|integer|nullable',
            'country_of_manufacture_id' => 'numeric|integer|nullable',
            'trademark_id' => 'numeric|integer|nullable',
            'description' => 'string"nullable',
            'type_id' => 'numeric|integer|nullable',
            'condition' => 'enum|nullable',
            'state' => 'enum|nullable',
            'units' => 'enum|nullable',
            // 'quantity_to_calculate' => 'numeric|integer|required',
            'quantity' => 'numeric|integer|required',
            'composition' => 'string|nullable',
            'kcalory' => 'decimal:1|required',
            'proteins' => 'decimal:1|required',
            'carbohydrates' => 'decimal:1|required',
            'fats' => 'decimal:1|required',
            'kcalory_per_unit' => 'decimal:2|required',
            'proteins_per_unit' => 'decimal:2|required',
            'carbohydrates_per_unit' => 'decimal:2|required',
            'fats_per_unit' => 'decimal:2|required',
            'data_source' => 'numeric|integer|nullable',
            'nutrients_and_vitamins' => 'json|nullable',
        ];
    }
}
