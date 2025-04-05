<?php

namespace App\Http\Controllers\CategoryGroup;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryGroupRequest;
use App\Http\Resources\CategoryGroupResource;
use App\Models\CategoryGroup;
use App\Models\FavoriteCategoryGroup;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryGroupStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CategoryGroupRequest $request)
    {
        $validated = $request->validated();

        $categoryGroup = CategoryGroup::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'is_enabled' => Auth::user()->is_admin ? $validated['is_enabled'] : true,
            'is_personal' => Auth::user()->is_admin ? $validated['is_personal'] : true,
            'user_id' => Auth::user()->is_admin ? $validated['user_id'] : Auth::user()->id,
        ]);

        if (isset($validated['is_favorite'])) {
            FavoriteCategoryGroup::create([
                'user_id' => Auth::user()->id,
                'category_group_id' => $categoryGroup->id,
            ]);
            $categoryGroup->is_favorite = true;
        }

        return new CategoryGroupResource($categoryGroup);
    }
}
