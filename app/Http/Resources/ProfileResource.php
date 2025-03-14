<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'height' => $this->height,
            'level_of_training' => $this->level_of_training,
            'level_of_daily_activity' => $this->level_of_daily_activity,
            // 'weight' => $this->weight,
            'weight' => json_decode($this->weight, JSON_UNESCAPED_UNICODE),
            'target_weight' => $this->target_weight,
            'target_energy_value_ration' => $this->target_energy_value_ration,
        ];
    }
}
