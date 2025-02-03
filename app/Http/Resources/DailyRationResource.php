<?php

namespace App\Http\Resources;

// use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyRationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $products = DailyRationProductResource::collection($this->products);

        $rationEnyrgyValue = [
            'kcalory' => 0,
            'proteins' => 0,
            'carbohydrates' => 0,
            'fats' => 0,
        ];

        foreach (iterator_to_array($products) as $products) {
            $rationEnyrgyValue['kcalory'] += $products->kcalory;
            $rationEnyrgyValue['proteins'] += $products->proteins;
            $rationEnyrgyValue['carbohydrates'] += $products->carbohydrates;
            $rationEnyrgyValue['fats'] += $products->fats;
        }

        return [
            'id' => $this->id,
            // 'name' => $this->name,
            'user_id' => $this->user_id,
            'description' => $this->description,
            // 'products' => $this->products,
            // including ration products, $this->products  ==  DailyRation->products 
            'products' => DailyRationProductResource::collection($this->products),
            'rationEnergyValue' => array_map(fn($x) => round($x, 1), $rationEnyrgyValue),
            // 'ration_summary' => $this->ration_summary,
            'date' => date_format($this->created_at, 'd-m-Y'),
        ];
    }
}
