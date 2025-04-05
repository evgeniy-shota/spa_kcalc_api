<?php

namespace App\Http\Controllers\CategoryGroup;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryGroupResource;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\FavoriteCategoryGroup;
use App\Models\HiddenCategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryGroupShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        $categoryGroup = CategoryGroup::find($id);
        // dd($categorysGroup);

        if (!isset($categoryGroup) || !$categoryGroup->is_enabled) {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        if (Auth::user()) {
            $categoryGroup->is_favorite = FavoriteCategoryGroup::where('user_id', Auth::user()->id)->where('category_group_id', $id)->exists();
            $categoryGroup->is_hidden = HiddenCategoryGroup::where('user_id', Auth::user()->id)->where('category_group_id', $id)->exists();
        }
        $categories = Category::where('category_group_id', $id)->whereEnabled()->whereAvailable(Auth::user()?->id)->get();
        // dd($categories);
        return new CategoryGroupResource($categoryGroup, $categories);
    }
}
