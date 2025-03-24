<?php

namespace App\Http\Resources;

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
        // the query time increases to >250 ms when using the category collection, 
        // without the category collection the query time is ~140-170 ms, 
        // if you transfer categories from the controller, 
        // the query time decreases to ~120-140 ms

        $user = Auth::user();
        // $categories = new CategoryCollection($this->categories()->whereEnabled()->whereAvailable($user ? $user->id : null)->get());
        // $categories = $this->categories()->whereEnabled()->whereAvailable($user ? $user->id : null)->get();
        // $categryGroupFavoriteStatus = $user ? UserFavoriteCategoriesGroup::where('user_id', $user->id)->where('category_groups_id', $this->id)->first() : null;
        $categories = $this->categories ?? $this->categoriesCollection;
        $categories = new CategoryCollection($categories);

        $is_favorite = $this->is_favorite ?? UserFavoriteCategoriesGroup::where('user_id', $user?->id)->where('category_groups_id', $this->id)->first() ? true : false;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            // 'is_favorite' => $categryGroupFavoriteStatus ? true : false,
            'is_favorite' => $this->when($is_favorite !== null, $is_favorite),
            'is_hidden' => $this->when($this->is_hidden, $this->is_hidden),
            'categories' => $this->when($categories, $categories),
            // 'categories' => $this->when($categories, ['count' => count($categories), 'data' => $categories]),
        ];
    }
}
