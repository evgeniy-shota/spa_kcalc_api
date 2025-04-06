<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

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
            'category_group_id' => 'required|numeric|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable:string|max:400',
            'is_personal' => 'nullable|boolean',
            'is_enabled' => 'nullable|boolean',
            'icon_path' => 'nullable|string|max:255',
            'is_favorite' => 'nullable|boolean',
            'is_hidden' => 'nullable|boolean',
            'thumbnail_image_path' => 'nullable|string|max:255',
        ];
    }
}
