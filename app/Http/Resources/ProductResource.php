<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'product_composition' => $this->product_composition,
            'description' => $this->description,
            'calory' => $this->calory,
            'protein' => $this->protein,
            'carbohydrates' => $this->carbohydrates,
            'fat' => $this->fat,
            'nutrients_and_vitamins' => $this->nutrients_and_vitamins,
            'is_visible' => $this->is_visible,
        ];
    }
}
