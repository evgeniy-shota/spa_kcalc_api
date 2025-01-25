<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalUserProductResource extends JsonResource
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
            'personal_user_category_id' => $this->personal_user_category_id,
            'name' => $this->name,
            'product_composition' => json_encode($this->product_composition, JSON_UNESCAPED_UNICODE),
            'description' => $this->description,
            'calory' => $this->calory,
            'protein' => $this->protein,
            'carbohydrates' => $this->carbohydrates,
            'fat' => $this->fat,
            'nutrients_and_vitamins' => json_encode($this->nutrients_and_vitamins, JSON_UNESCAPED_UNICODE),
            'is_visible' => $this->is_visible,
        ];
    }

    public function withResponse(Request $request, JsonResponse $response)
    {
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
