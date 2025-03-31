<?php

namespace App\Http\Resources;

use App\Models\HiddenCategory;
use App\Models\UserFavoriteCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // dd($this->collection);

        if (Auth::user()) {
            // $favoriteCategories = array_flip(array_column(
            //     UserFavoriteCategory::where('user_id', Auth::user()->id)->get()->toArray(),
            //     'category_id'
            // ));
            // $hiddenCategories  = array_flip(array_column(
            //     HiddenCategory::where('user_id', Auth::user()->id)->get()->toArray(),
            //     'category_id'
            // ));
            $favoriteCategories =
                UserFavoriteCategory::where('user_id', Auth::user()->id)->get()->keyBy('category_id');
            $hiddenCategories  =
                HiddenCategory::where('user_id', Auth::user()->id)->get()->keyBy('category_id');

            $newCollection = array_map(function ($item) use ($favoriteCategories, $hiddenCategories) {
                // $item['is_favorite'] = isset($favoriteCategories[$item['id']]);
                // $item['is_hidden'] = isset($hiddenCategories[$item['id']]);
                $item['is_favorite'] = $favoriteCategories->has($item['id']);
                $item['is_hidden'] = $hiddenCategories->has($item['id']);
                return $item;
            }, $this->collection->toArray());
            $this->collection = $newCollection;
        }

        // dd($favoriteCategories);
        return [
            'count' => count($this->collection),
            'data' => $this->collection,
            // 'id' => $this->id,
            // 'name' => $this->name,
            // 'is_visible' =>$this->is_visible,
        ];
    }
}
