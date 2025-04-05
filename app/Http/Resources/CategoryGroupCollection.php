<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryGroupCollection extends ResourceCollection
{
    private $favoriteCategoryGroups;
    private $hiddenCategoryGroups;
    private $availableCategroies;

    public function __construct($resource, $favoriteGroups = null, $hiddenGroups = null, $availableCategroies = null)
    {
        parent::__construct($resource);
        $this->favoriteCategoryGroups = $favoriteGroups;
        $this->hiddenCategoryGroups = $hiddenGroups;
        $this->availableCategroies = $availableCategroies;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        if ($this->favoriteCategoryGroups !== null || $this->hiddenCategoryGroups !== null || $this->availableCategroies !== null) {
            $newGroupsCollection = $this->collection->map(function ($item) {
                if ($this->favoriteCategoryGroups !== null) {
                    $item['is_favorite'] = $this->favoriteCategoryGroups->keyBy('category_group_id')->has($item['id']);
                }

                if ($this->hiddenCategoryGroups !== null) {
                    $item['is_hidden'] = $this->hiddenCategoryGroups->keyBy('category_group_id')->has($item['id']);
                }

                if ($this->availableCategroies !== null) {
                    $item['availableCategories'] = $this->availableCategroies->filter(function ($catItem) use ($item) {
                        if ($catItem['category_group_id'] === $item['id']) {
                            return $catItem;
                        }
                    })->values();
                }
                return $item;
            });
            $this->collection = $newGroupsCollection;
        }

        return [
            'count' => count($this->collection),
            'data' => $this->collection,
            // 'data' => $newGroupsCollection,
        ];
    }
}
