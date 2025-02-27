<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        dd($this);
        
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'type' => 'products',
            'name' => $this->name,
            'calory' => $this->calory,
            'proteins' => $this->proteins,
            'carbohydrates' => $this->carbohydrates,
            'fats' => $this->fats,
        ];
    }

    public function withResponse(Request $request, JsonResponse $response)
    {
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
