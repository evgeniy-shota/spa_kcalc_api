<?php

namespace App\Http\Requests\CategoryGroup;

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

    // filter query params by type
    protected function prepareForValidation(): void
    {
        $this->merge([
            'categoryGroupId' => $this->query('categoryGroupId') !== null && !preg_match('/[^\d,]/', $this->query('categoryGroupId')) ? explode(',', $this->query('categoryGroupId')) : null,
            'isFavorite' => filter_var($this->query('isFavorite'), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE),
            'isHidden' => filter_var($this->query('isHidden'), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE),
            'isPersonal' => filter_var($this->query('isPersonal'), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE),
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
            'categoryGroupId' => 'nullable|array',
            'isFavorite' => 'nullable|boolean',
            'isHidden' => 'nullable|boolean',
            'isPersonal' => 'nullable|boolean',
        ];
    }
}
