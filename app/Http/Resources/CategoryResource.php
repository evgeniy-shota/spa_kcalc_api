<?php

namespace App\Http\Resources;

use App\Models\UserFavoriteCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::user();
        $isFavorite = $user ? UserFavoriteCategory::where('user_id', $user->id)->where('category_id', $this->id)->first() : null;
        $isHidden = false;
        // dump($this->products);
        return [
            "id" => $this->id,
            "category_group_id" => $this->category_group_id,
            "name" => $this->name,
            "description" => $this->description,
            "is_personal" => $this->is_personal,
            "icon_path" => $this->icon_path,
            "thumbnail_image_path" => $this->thumbnail_image_path,
            'is_favorite' => $isFavorite ? true : false,
            'is_hidden' => $isHidden ? true : false,
            'products' => $this->whenNotNull($this->categoryProducts),
        ];
    }
}
