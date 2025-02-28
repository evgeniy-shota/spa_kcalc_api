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
            'category_group_id' => 'required|int',
            'name' => 'required|string|max:255',
            'is_personal' => 'required|boolean',
            'is_enabled' => 'required|boolean',
            'icon_path' => 'nullable|string|max:255',
            'thumbnail_image_path' => 'nullable|string|max:255',
        ];
    }
}
