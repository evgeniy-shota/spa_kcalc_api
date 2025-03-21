<?php

namespace App\Http\Resources;

use App\Models\UserFavoriteCategoriesGroup;
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

        $categories = new CategoryCollection($this->categories()->whereEnabled()->whereAvailable($user ? $user->id : null)->get());
        $categryGroupFavoriteStatus = UserFavoriteCategoriesGroup::where('user_id', $user->id)->where('category_groups_id', $this->id)->first();
        // $categories =  new CategoryCollection($this->categories()->where('is_enabled', true)->where('is_personal', false)->orWhere('user_id', $user->id)->get()) :
        //     new CategoryCollection($this->categories()->where('is_enabled', true)->where('is_personal', false)->get());

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_favorite' => $categryGroupFavoriteStatus ? true : false,
            'is_hidden' => false,
            'categories' => $categories,
        ];
    }
}
