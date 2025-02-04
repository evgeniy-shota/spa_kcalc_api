<?php

namespace App\Http\Resources;

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
        //добавить ценногсть на грам
        return [
            'id' => $this->id,
            'time_of_use' => $this->time_of_use,
            'daily_ration_id' => $this->daily_ration_id,
            'product_id' => $this->product_id,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'kcalory_per_unit' => $this->kcalory_per_unit,
            'proteins_per_unit' => $this->proteins_per_unit,
            'carbohydrates_per_unit' => $this->carbohydrates_per_unit,
            'fats_per_unit' => $this->fats_per_unit,
        ];
    }
}
