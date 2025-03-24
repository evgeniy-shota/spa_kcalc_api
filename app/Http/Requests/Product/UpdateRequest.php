<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ProductCondition;
use App\Enums\ProductState;
use App\Enums\ProductUnits;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'user_id' => 'nullable|numeric|integer',
            'category_id' => 'nullable|numeric|integer',
            'type_id' => 'nullable|numeric|integer',
            'is_personal' => 'nullable|boolean',
            'is_enabled' => 'nullable|boolean',
            'is_abstract' => 'nullable|boolean',
            'name' => 'nullable|string',
            'thumbnail_image_name' => 'nullable|string',
            'manufacturer' => 'nullable|string|max:255',
            'country_of_manufacture' => 'nullable|string|max:255',
            'trademark_id' => 'nullable|numeric|integer',
            'description' => 'nullable|string',
            'units' => ['nullable', Rule::enum(ProductUnits::class)],
            'condition' => ['nullable', Rule::enum(ProductCondition::class)],
            'state' => ['nullable', Rule::enum(ProductState::class)],
            'quantity_to_calculate' => 'nullable|numeric|integer',
            'quantity' => 'nullable|numeric|integer',
            'composition' => 'nullable|string',
            'kcalory' => 'nullable|decimal:1',
            'proteins' => 'nullable|decimal:1',
            'carbohydrates' => 'nullable|decimal:1',
            'fats' => 'nullable|decimal:1',
            'kcalory_per_unit' => 'nullable|decimal:2',
            'proteins_per_unit' => 'nullable|decimal:2',
            'carbohydrates_per_unit' => 'nullable|decimal:2',
            'fats_per_unit' => 'nullable|decimal:2',
            'nutrients_and_vitamins' => 'nullable|json',
            'data_source' => 'nullable|string',

            'is_favorite' => 'nullable|boolean',
            'is_hidden' => 'nullable|boolean',
        ];
    }
}
