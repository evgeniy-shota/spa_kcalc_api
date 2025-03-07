<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyRationProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = Product::find($this->product_id);
        //добавить ценногсть на грам
        return [
            'id' => $this->id,
            'time' => $this->time,
            'daily_ration_id' => $this->daily_ration_id,
            'product_id' => $this->product_id,
            'name' => $product->name,
            'quantity' => $this->quantity,
            'kcalory_per_unit' => $product->kcalory_per_unit,
            'proteins_per_unit' => $product->proteins_per_unit,
            'carbohydrates_per_unit' => $product->carbohydrates_per_unit,
            'fats_per_unit' => $product->fats_per_unit,
        ];
    }
}
