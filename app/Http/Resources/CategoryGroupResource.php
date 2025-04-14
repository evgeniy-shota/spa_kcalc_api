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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_personal' => $this->is_personal,
            'is_favorite' => $this->when($this->is_favorite !== null, $this->is_favorite),
            'is_hidden' => $this->when($this->is_hidden !== null, $this->is_hidden),
            // 'categories' => isset($this->availableCategories) ? new CategoryCollection($this->availableCategories) : [],
            'categories' => $this->when(isset($this->availableCategories), function () {
                return new CategoryCollection($this->availableCategories);
            }),
            // 'categories' => $this->categoriesCollection !== null ? $this->categoriesCollection : (isset($this->availableCategories) ? $this->availableCategories : null),
            // 'categories' => $this->when($this->categoriesCollection !== null, $this->categoriesCollection),
        ];
    }
}
