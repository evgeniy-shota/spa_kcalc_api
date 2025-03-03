<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DataSourceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_orig' => $this->name_orig,
            'description_ru' => $this->description_ru,
            'description_en' => $this->description_en,
            'citation' => $this->citation,
            'thumbnail_image_name' => $this->thumbnail_image_name,
        ];
    }
}
