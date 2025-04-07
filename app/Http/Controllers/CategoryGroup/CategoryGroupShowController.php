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
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return response()->json(['message' => 'Bad request'], 400);
        }
        $categoryGroup = CategoryGroup::where('id', $id);

        if (Auth::user() === null || Auth::user()->is_admin !== true) {
            $categoryGroup = $categoryGroup->whereEnabled()->whereAvailable(Auth::user() ? Auth::user()->id : null);
        }
        $categoryGroup = $categoryGroup->first();

        if (!isset($categoryGroup)) {
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
