<?php

namespace App\Http\Resources;

use App\Models\HiddenCategoryGroup;
use App\Models\FavoriteCategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CategoryGroupResource extends JsonResource
{
    private $returnFullData;
    private $categoriesCollection;

    public function __construct($resource,  $categoriesCollection = null, $returnFullData = false)
    {
        parent::__construct($resource);
        $this->returnFullData = $returnFullData;
        $this->categoriesCollection = $categoriesCollection;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $user = Auth::user();

        // $categories = $this->availableCategories ?? $this->categoriesCollection;
        // $categories = $categories !== null ? new CategoryCollection($categories) : null;

        // $is_favorite = null;
        // $is_hidden = null;

        // if ($user) {
        //     $is_favorite = $this->is_favorite ?? FavoriteCategoryGroup::where('user_id', $user?->id)->where('category_groups_id', $this->id)->exists();
        //     $is_hidden = $this->is_hidden ?? HiddenCategoryGroup::where('user_id', $user->id)->where('category_group_id', $this->id)->exists();
        // }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_personal' => $this->is_personal,
            'is_favorite' => $this->when($this->is_favorite !== null, $this->is_favorite),
            'is_hidden' => $this->when($this->is_hidden !== null, $this->is_hidden),
            // 'is_favorite' => $this->when($is_favorite !== null, $is_favorite),
            // 'is_hidden' => $this->when($is_hidden !== null, $is_hidden),
            'categories' => $this->when($this->categoriesCollection !== null, $this->categoriesCollection),
        ];
    }
}
