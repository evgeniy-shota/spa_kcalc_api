<?php

namespace App\Http\Controllers\CategoryGroup;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryGroupRequest;
use App\Http\Resources\CategoryGroupResource;
use App\Models\CategoryGroup;
use App\Models\FavoriteCategoryGroup;
use App\Models\HiddenCategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryGroupUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CategoryGroupRequest $request, string $id)
    {
        $user = Auth::user();
        // $user = User::find(3);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $categoryGroup = CategoryGroup::find($id);

        if (!$categoryGroup) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $validated = $request->validated();

        if (isset($validated['is_favorite'])) {
            $favoriteCategoryGroup = FavoriteCategoryGroup::where('user_id', $user->id)->where('category_group_id', $id)->first();

            if ($validated['is_favorite'] === true) {
                if ($favoriteCategoryGroup) {
                    return response()->json(['message' => 'Bad Request'], 400);
                }
                FavoriteCategoryGroup::create([
                    'user_id' => $user->id,
                    'category_group_id' => $id,
                ]);
            }

            if ($validated['is_favorite'] == false) {
                if (!$favoriteCategoryGroup) {
                    return response()->json(['message' => 'Bad Request'], 400);
                }
                $favoriteCategoryGroup->delete();
            }
            $categoryGroup->is_favorite = $validated['is_favorite'];
        }

        if (isset($validated['is_hidden'])) {
            $hiddenCategoryGroup  = HiddenCategoryGroup::where('user_id', $user->id)->where('category_group_id', $id)->first();

            if ($validated['is_hidden'] === true) {
                if ($hiddenCategoryGroup) {
                    return response()->json(['message' => 'Bad Request'], 400);
                }
                HiddenCategoryGroup::create([
                    'user_id' => $user->id,
                    'category_group_id' => $id,
                ]);
            }

            if ($validated['is_hidden'] === false) {
                if (!$hiddenCategoryGroup) {
                    return response()->json(['message' => 'Bad Request'], 400);
                }
                $hiddenCategoryGroup->delete();
            }
            $categoryGroup->is_favorite = $validated['is_hidden'];
        }

        if (
            Auth::user()->id_admin === true ||
            ($categoryGroup->is_personal === true && $categoryGroup->user_id === Auth::user()->id)
        ) {
            if ($validated['name']) {
                $categoryGroup->name = $validated['name'];
            }

            if ($validated['description']) {
                $categoryGroup->description = $validated['description'];
            }

            if ($validated['is_enabled']) {
                if (Auth::user()->id_admin === true) {
                    $categoryGroup->is_enabled = $validated['is_enabled'];
                } else {
                    $categoryGroup->is_enabled = true;
                }
            }

            if ($validated['is_personal']) {
                if (Auth::user()->id_admin === true) {
                    $categoryGroup->is_personal = $validated['is_personal'] ?? true;
                } else {
                    $categoryGroup->is_personal = true;
                }
            }
            $categoryGroup->save();
        }
        return new CategoryGroupResource($categoryGroup);
    }
}
