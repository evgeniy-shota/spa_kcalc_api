<?php

namespace App\Http\Resources;

use App\Models\FavoriteCategory;
use App\Models\HiddenCategory;
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
        // $user = Auth::user();
        // $isFavorite = null;
        // $isHidden = null;

        // if ($user) {
        //     $isFavorite = UserFavoriteCategory::where('user_id', $user->id)->where('category_id', $this->id)->first() ? true : false;
        //     $isHidden = HiddenCategory::where('user_id', $user->id)->where('category_id', $this->id)->first() ? true : false;
        // }
        $isFavorite = null;
        $isHidden = null;

        if (Auth::user() !== null) {
            $isFavorite = $this->is_favorite !== null ? $this->is_favorite : FavoriteCategory::where('user_id', Auth::user()->id)->where('category_id', $this->id)->exists();
            $isHidden = $this->is_hidden !== null ? $this->is_hidden : HiddenCategory::where('user_id', Auth::user()->id)->where('category_id', $this->id)->exists();
        }

        return [
            "id" => $this->id,
            "category_group_id" => $this->category_group_id,
            "name" => $this->name,
            "description" => $this->description,
            "is_personal" => $this->is_personal,
            "icon_path" => $this->icon_path,
            "thumbnail_image_path" => $this->thumbnail_image_path,
            'is_favorite' => $this->when(Auth::user() !== null, $isFavorite),
            'is_hidden' => $this->when(Auth::user() !== null, $isHidden),
            // 'products' => $this->whenNotNull($this->categoryProducts),
        ];
    }
}
