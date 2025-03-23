<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Contracts\Validation\ValidationRule;

class CategoryRequest extends FormRequest
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
            'user_id' => 'nullable|int',
            'category_group_id' => 'nullable|int',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable:string',
            'is_personal' => 'nullable|boolean',
            'is_enabled' => 'nullable|boolean',
            'icon_path' => 'nullable|string|max:255',
            'is_favorite' => 'nullable|boolean',
            'is_hidden' => 'nullable|boolean',
            'thumbnail_image_path' => 'nullable|string|max:255',
        ];
    }
}
