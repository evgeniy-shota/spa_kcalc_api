<?php

namespace App\Http\Requests;

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
            'user_id' => 'numeric|integer|required',
            'is_personal' => 'boolean|nullable',
            'is_enabled' => 'boolean|nullable',
            'is_abstract' => 'boolean|nullable',
            'name' => 'string|required',
            'thumbnail_image_name' => 'string|nullable',
            'manufacturer_id' => 'numeric|integer|nullable',
            'country_of_manufacture_id' => 'numeric|integer|nullable',
            'trademark_id' => 'integer',
            'description' => 'string',
            'type_id' => 'foreignId',
            'condition' => 'enum',
            'state' => 'enum',
            'units' => 'enum',
            'quantity_to_calculate' => 'integer',
            'quantity' => 'integer',
            'composition' => 'string',
            'kcalory' => 'float',
            'proteins' => 'float',
            'carbohydrates' => 'float',
            'fats' => 'float',
            'kcalory_per_unit' => 'float',
            'proteins_per_unit' => 'float',
            'carbohydrates_per_unit' => 'float',
            'fats_per_unit' => 'float',
            'data_source' => 'foreignId',
            'nutrients_and_vitamins' => 'json',
        ];
    }
}
