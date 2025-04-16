<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Traits\ValidateArray;
use App\Utils\FilterVar;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    use ValidateArray;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'isPersonal' => $this->query('isPersonal') ?
                FilterVar::filterBool($this->query('isPersonal')) : null,

            'isAbstract' => $this->query('isAbstract') ?
                FilterVar::filterBool($this->query('isAbstract')) : null,

            'isFavorite' => $this->query('isFavorite') ?
                FilterVar::filterBool($this->query('isFavorite')) : null,

            'isHidden' => $this->query('isHidden') ?
                FilterVar::filterBool($this->query('isHidden')) : null,


            'categories' => $this->query('categories') !== null ?
                $this->validateArray(
                    $this->query('categories'),
                    0,
                    9999,
                    [FilterVar::class, 'filterInt']
                ) : null,

            'manufacturer' => $this->query('manufacturer') !== null ?
                $this->validateArray(
                    $this->query('manufacturer'),
                    0,
                    9999,
                    [FilterVar::class, 'filterInt']
                ) : null,

            'countryOfManufacture' => $this->query('country_of_manufacture') !== null ?
                $this->validateArray(
                    $this->query('country_of_manufacture'),
                    0,
                    9999,
                    [FilterVar::class, 'filterInt']
                ) : null,

            'quantity' => $this->query('quantity') !== null ?
                $this->validateArray(
                    $this->query('quantity'),
                    2,
                    2,
                    [FilterVar::class, 'filterInt']
                ) : null,

            'kcalory' => $this->query('kcalory') !== null ?
                $this->validateArray(
                    $this->query('kcalory'),
                    2,
                    2,
                    [FilterVar::class, 'filterInt']
                ) : null,

            'proteins' => $this->query('proteins') !== null ?
                $this->validateArray(
                    $this->query('proteins'),
                    2,
                    2,
                    [FilterVar::class, 'filterInt']
                ) : null,

            'carbohydrates' => $this->query('carbohydrates') !== null ?
                $this->validateArray(
                    $this->query('carbohydrates'),
                    2,
                    2,
                    [FilterVar::class, 'filterInt']
                ) : null,

            'fats' => $this->query('fats') !== null ?
                $this->validateArray(
                    $this->query('fats'),
                    2,
                    2,
                    [FilterVar::class, 'filterInt']
                ) : null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sort' => 'nullable|string',

            'categories' => 'nullable|array',
            // 'type_id' => 'nullable|integer',
            'isPersonal' => 'nullable|boolean',
            'isAbstract' => 'nullable|boolean',
            'isFavorite' => 'nullable|boolean',
            'isHidden' => 'nullable|boolean',
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
