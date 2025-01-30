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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'products' => $this->products,
            'ration_summary' => $this->ration_summary,
            'date' => date_format($this->created_at, 'd-m-Y'),
        ];
    }
}
