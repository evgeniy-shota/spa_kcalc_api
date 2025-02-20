<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "category_group_id" => $this->category_group_id,
            "name" => $this->name,
            "description" => $this->description,
            "is_personal" => $this->is_personal,
            "icon_path" => $this->icon_path,
            "thumbnail_image_path" => $this->thumbnail_image_path,
        ];
    }
}
