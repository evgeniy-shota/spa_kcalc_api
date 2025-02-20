<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CategoryGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::user();
        
        $categories = $user ? new CategoryCollection($this->categories()->where('is_enabled', true)->where('is_personal', false)->orWhere('user_id', $user->id)->get()) :
            new CategoryCollection($this->categories()->where('is_enabled', true)->where('is_personal', false)->get());

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'categories' => $categories,
        ];
    }
}
