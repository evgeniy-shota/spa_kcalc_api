<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryGroupCollection extends ResourceCollection
{
    private $favoriteGroups;
    private $categroies;

    public function __construct($resource, $favoriteGroups, $categories)
    {
        parent::__construct($resource);
        $this->favoriteGroups = $favoriteGroups ??  collect([]);
        $this->categroies = $categories ?? collect([]);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dump($this->additionalData);
        // dump($this->collection);
        $newGroupsCollection = $this->collection->map(function ($item) {
            $item['is_favorite'] = $this->favoriteGroups->keyBy('category_groups_id')->has($item['id']);
            $item['categories'] = $this->categroies->filter(function ($catItem) use ($item) {
                if ($catItem['category_group_id'] === $item['id']) {
                    return $catItem;
                }
            })->values();
            return $item;
        });

        // $newCategories = collections
        // dd($newGroupsCollection);
        // dump($this->additionalData->keyBy('category_groups_id'));
        // dump($newCollection);
        // $this->collection->additionalData = $this->additionalData;
        return [
            'count' => count($this->collection),
            // 'data' => $this->collection,
            'data' => $newGroupsCollection,
        ];
    }
}
