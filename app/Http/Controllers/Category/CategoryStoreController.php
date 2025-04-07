<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\FavoriteCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();

        $category = Category::create([
            'user_id' => Auth::user()->is_admin ? $validated['user_id'] : Auth::user()->id,
            'category_group_id' => $validated['category_group_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_personal' => Auth::user()->is_admin ? $validated['is_personal'] : true,
            'is_enabled' => Auth::user()->is_admin ? $validated['is_enabled'] : true,
            'icon_path' => $validated['icon_path'] ?? null,
            'thumbnail_image_path' => $validated['thumbnail_image_path'] ?? null,
        ]);

        if (isset($validated['is_favorite'])) {
            FavoriteCategory::create([
                'user_id' => Auth::user()->id,
                'category_id' => $category->id,
            ]);
            $category->is_favorite = true;
        }

        return new CategoryResource($category);
    }
}
