<?php

namespace App\Http\Requests\CategoryGroup;

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

    // filter query params by type
    protected function prepareForValidation(): void
    {
        $this->merge([
            'categoryGroupsId' => $this->query('categoryGroupsId') !== null ?
                $this->validateArray(
                    $this->query('categoryGroupsId'),
                    0,
                    9999,
                    [FilterVar::class, 'filterInt']
                ) : null,

            'isFavorite' => $this->query('isFavorite') !== null ?
                FilterVar::filterBool($this->query('isFavorite')) : null,

            'isHidden' => $this->query('isHidden') !== null ?
                FilterVar::filterBool($this->query('isHidden')) : null,

            'isPersonal' => $this->query('isPersonal') !== null ?
                FilterVar::filterBool($this->query('isPersonal')) : null,

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
            'categoryGroupsId' => 'nullable|array',
            'isFavorite' => 'nullable|boolean',
            'isHidden' => 'nullable|boolean',
            'isPersonal' => 'nullable|boolean',
        ];
    }
}
