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
            'category_id' => 'required|numeric|integer',
            'user_id' => 'nullable|numeric|integer',
            'is_personal' => 'nullable|boolean',
            'is_enabled' => 'nullable|boolean',
            'is_abstract' => 'nullable|boolean',
            'name' => 'required|string|max:255',
            'thumbnail_image_name' => 'nullable|string',
            'manufacturer_id' => 'nullable|numeric|integer',
            'country_of_manufacture_id' => 'nullable|numeric|integer',
            'trademark_id' => 'nullable|numeric|integer',
            'description' => 'nullable|string',
            'type_id' => 'nullable|numeric|integer',
            'condition' => 'nullable|enum',
            'state' => 'nullable|enum',
            'units' => 'nullable|enum',
            'quantity_to_calculate' => 'nullable|numeric|integer',
            'quantity' => 'required|numeric|integer',
            'composition' => 'nullable|string',
            'kcalory' => 'required|decimal:0,1',
            'proteins' => 'required|decimal:0,1',
            'carbohydrates' => 'required|decimal:0,1',
            'fats' => 'required|decimal:0,1',
            // 'kcalory_per_unit' => 'required|decimal:0,2',
            // 'proteins_per_unit' => 'required|decimal:0,2',
            // 'carbohydrates_per_unit' => 'required|decimal:0,2',
            // 'fats_per_unit' => 'required|decimal:0,2',
            'data_source' => 'nullable|numeric|integer',
            'nutrients_and_vitamins' => 'nullable|json',
            'is_favorite' => 'nullable|boolean',
        ];
    }
}
