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

    protected function validateArray(array $data, int $minCount, int $maxCount, callable $fnForValidate)
    {
        if (!isset($data) || count($data) < $minCount || count($data) > $maxCount) {
            return false;
        }

        for ($i = 0, $size = count($data); $i < $size; $i++) {
            if (!$fnForValidate($data[$i])) {
                return null;
            }
        }

        return $data;
    }

    protected function convertQueryStringToArray($data, $reg, bool $abortIfRegMatch = true): array|null
    {
        if (!isset($data) || strlen($data) === 0) {
            return null;
        }

        if (preg_match($reg, $data)) {
            if ($abortIfRegMatch) {
                return null;
            }
            return explode(',', $data);
        } else {
            if ($abortIfRegMatch) {
                return explode(',', $data);
            }
        }
        return null;
    }

    protected function prepareForValidation()
    {
        $arrayValidationCall = function ($value) {

            if (filter_var($value, FILTER_VALIDATE_INT) !== false) {
                return true;
            }

            if (filter_var($value, FILTER_VALIDATE_FLOAT) !== false) {
                return true;
            }

            return false;
        };

        $regNoDigitsAndComma = '/[^,\d]/';
        $this->merge([
            'isPersonal' => $this->query('isPersonal') ? filter_var($this->query('isPersonal'), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) : null,
            'isAbstract' => $this->query('isAbstract') ? filter_var($this->query('isAbstract'), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) : null,
            'isFavorite' => $this->query('isFavorite') ? filter_var($this->query('isFavorite'), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) : null,
            'isHidden' => $this->query('isHidden') ? filter_var($this->query('isHidden'), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) : null,
            'categories' => $this->convertQueryStringToArray($this->query('categories'), $regNoDigitsAndComma),
            'manufacturer' => $this->convertQueryStringToArray($this->query('manufacturer'), $regNoDigitsAndComma),
            'countryOfManufacture' => $this->convertQueryStringToArray($this->query('country_of_manufacture'), $regNoDigitsAndComma),
            'quantity' => $this->query('quantity') !== null ? $this->validateArray($this->query('quantity'), 2, 2, $arrayValidationCall) : null,
            'kcalory' => $this->query('kcalory') !== null ? $this->validateArray($this->query('kcalory'), 2, 2, $arrayValidationCall) : null,
            'proteins' => $this->query('proteins') !== null ? $this->validateArray($this->query('proteins'), 2, 2, $arrayValidationCall) : null,
            'carbohydrates' => $this->query('carbohydrates') !== null ? $this->validateArray($this->query('carbohydrates'), 2, 2, $arrayValidationCall) : null,
            'fats' => $this->query('fats') !== null ? $this->validateArray($this->query('fats'), 2, 2, $arrayValidationCall) : null,
            // 'quantity' => $this->convertQueryStringToArray($this->query('quantity'), $regNoDigitsAndComma),
            // 'kcalory' => $this->convertQueryStringToArray($this->query('kcalory'), $regNoDigitsAndComma),
            // 'proteins' => $this->convertQueryStringToArray($this->query('proteins'), $regNoDigitsAndComma),
            // 'carbohydrates' => $this->convertQueryStringToArray($this->query('carbohydrates'), $regNoDigitsAndComma),
            // 'fats' => $this->convertQueryStringToArray($this->query('fats'), $regNoDigitsAndComma),
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
