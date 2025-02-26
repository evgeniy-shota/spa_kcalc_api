<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PharIo\Manifest\Email;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'name' => $this->name,
            'is_banned' => $this->is_banned,
            'date_of_registration' => date_format($this->created_at, 'Y-m-d'),
            'profile' => new ProfileResource($this->profile),
        ];
    }
}
