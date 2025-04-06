<?php

namespace App\Http\Requests\Category;

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
            'isFavorite' => 'nullable|boolean',
            'isHidden' => 'nullable|boolean',
            'isPersonal' => 'nullable|boolean',
        ];
    }
}
