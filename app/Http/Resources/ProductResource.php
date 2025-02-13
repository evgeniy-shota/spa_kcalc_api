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


        // dd($request->route()->getName());

        $currentRout = $request->route()->getName();
        // dump($request->short_output);
        // return parent::toArray($request);

        if (in_array($currentRout, ['products.index', 'categories.show', 'search'])) {
            return [
                "id" => $this->id,
                "name" =>  $this->name,
                "quantity_to_calculate" => $this->quantity_to_calculate,
                "quantity" => $this->quantity,
                "kcalory" =>  $this->kcalory,
                "proteins" => $this->proteins,
                "carbohydrates" =>  $this->carbohydrates,
                "fats" => $this->fats,
            ];
        }

        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'is_personal' => $this->is_personal,
            'name' => $this->name,
            'manufacturer' => $this->manufacturer,
            'countryOfManufacture' => $this->country_of_manufacture,
            'trademark_id' => $this->trademark_id,
            'description' => $this->description,
            'units_of_measurement' => $this->units_of_measurement,
            'quantity_to_calculate' => $this->quantity_to_calculate,
            'quantity' => $this->quantity,
            'composition' => json_encode($this->product_composition, JSON_UNESCAPED_UNICODE),
            'kcalory' => $this->kcalory,
            'proteins' => $this->proteins,
            'carbohydrates' => $this->carbohydrates,
            'fats' => $this->fats,
            'nutrientAndVitamines' => json_decode($this->nutrients_and_vitamins, JSON_UNESCAPED_UNICODE),

            'type' => 'product',
        ];
    }
}
