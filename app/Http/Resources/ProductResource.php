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
        dump($request->short_output);
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'is_personal' => $this->is_personal,
            'name' => $this->name,
            'manufacturer' => $this->manufacturer,
            'country_of_manufacture' => $this->country_of_manufacture,
            'trademark_id' => $this->trademark_id,
            'description' => $this->description,
            'units_of_measurement' => $this->units_of_measurement,
            'quantity_to_calculate' => $this->quantity_to_calculate,
            'quantity' => $this->quantity,
            'product_composition' => json_encode($this->product_composition),
            'kcalory' => $this->kcalory,
            'proteins' => $this->proteins,
            'carbohydrates' => $this->carbohydrates,
            'fats' => $this->fats,
            'nutrients_and_vitamins' => json_decode($this->nutrients_and_vitamins),

            'type' => 'product'
        ];

        return [
            "id" => $this->id,
            "name" =>  $this->name,
            "quantity" => $this->quantity,
            "kcalory" =>  $this->kcalory,
            "proteins" => $this->proteins,
            "carbohydrates" =>  $this->carbohydrates,
            "fats" => $this->fats,
        ];
    }
}
