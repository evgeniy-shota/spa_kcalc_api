<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|int',
            'category_group_id' => 'required|int',
            'name' => 'require|string|max:255',
            'is_personal' => 'require|boolean',
            'is_enabled' => 'require|boolean',
            'icon_path' => 'nullable|string|max:255',
            'thumbnail_image_path' => 'nullable|string|max:255',
        ];
    }
}
