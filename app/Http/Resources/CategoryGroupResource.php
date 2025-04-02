<?php

namespace App\Http\Resources;

use App\Models\HiddenCategoryGroup;
use App\Models\UserFavoriteCategoriesGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CategoryGroupResource extends JsonResource
{


    public function __construct($resource, private $categoriesCollection = null)
    {
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::user();
        // $categories = new CategoryCollection($this->categories()->whereEnabled()->whereAvailable($user ? $user->id : null)->get());
        // $categories = $this->categories()->whereEnabled()->whereAvailable($user ? $user->id : null)->get();
        // $categryGroupFavoriteStatus = $user ? UserFavoriteCategoriesGroup::where('user_id', $user->id)->where('category_groups_id', $this->id)->first() : null;
        // dump($this->categories);
        $categories = $this->availableCategories ?? $this->categoriesCollection;
        $categories = $categories !== null ? new CategoryCollection($categories) : null;
        // dd($categories);
        $is_favorite = null;
        $is_hidden = null;

        if ($user) {
            $is_favorite = $this->is_favorite ?? UserFavoriteCategoriesGroup::where('user_id', $user?->id)->where('category_groups_id', $this->id)->first() ? true : false;
            $is_hidden = $this->is_hidden ?? HiddenCategoryGroup::where('user_id', $user->id)->where('category_group_id', $this->id)->exists();
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            // 'is_favorite' => $categryGroupFavoriteStatus ? true : false,
            'is_favorite' => $this->when($is_favorite !== null, $is_favorite),
            'is_hidden' => $this->when($is_hidden !== null, $is_hidden),
            'categories' => $this->when($categories !== null, $categories),
            // 'categories' => $this->when($categories, ['count' => count($categories), 'data' => $categories]),
        ];
    }
}
