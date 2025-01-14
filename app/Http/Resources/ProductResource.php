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
            'proteins' => $this->proteins,
            'carbohydrates' => $this->carbohydrates,
            'fats' => $this->fats,
            'nutrients_and_vitamins' => json_decode($this->nutrients_and_vitamins),
            'is_visible' => $this->is_visible,
        ];
    }
}
