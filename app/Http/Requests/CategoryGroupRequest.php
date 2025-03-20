<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryGroupRequest extends FormRequest
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
            'id' => 'required|numeric|integer',
            'name' => 'nullable|string:255',
            'description' => 'nullable|string:400',
            'is_favorite' => 'nullable|boolean',
            'is_hidden' => 'nullable|boolean',
            'is_enabled' => 'nullable|boolean',
        ];
    }
}
