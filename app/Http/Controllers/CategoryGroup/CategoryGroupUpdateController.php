<?php

namespace App\Http\Controllers\CategoryGroup;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryGroup\UpdateRequest;
use App\Http\Resources\CategoryGroupResource;
use App\Models\CategoryGroup;
use App\Models\FavoriteCategoryGroup;
use App\Models\HiddenCategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryGroupUpdateController extends Controller
{
    protected const NOT_AVAILABLE_FOR_NON_ADMIN = ['is_enabled', 'is_personal', 'user_id'];
    protected const NOT_AVAILABLE_FOR_NON_PERSONAL = ['name', 'description'];
    protected const NOT_AVAILABLE_FOR_MASS_ASSIGNMENT = ['is_favorite', 'is_hidden'];

    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $request, string $id)
    {

        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return response()->json(['message' => 'Bad request'], 400);
        }

        $categoryGroup = CategoryGroup::where('id', $id);

        if (Auth::user()->is_admin !== true) {
            $categoryGroup->whereEnabled()->whereAvailable(Auth::user()->id);
        }
        $categoryGroup = $categoryGroup->first();

        if (!isset($categoryGroup)) {
            // ||($categoryGroup->is_enabled !== true && Auth::user()->is_admin !== true)
            return response()->json(['message' => 'Not Found'], 404);
        }
        $validated = $request->validated();

        if (isset($validated['is_favorite'])) {
            $favoriteCategoryGroup = FavoriteCategoryGroup::where('user_id', Auth::user()->id)->where('category_group_id', $id)->first();

            if ($validated['is_favorite'] === true) {
                if ($favoriteCategoryGroup === null) {
                    FavoriteCategoryGroup::create([
                        'user_id' =>  Auth::user()->id,
                        'category_group_id' => $id,
                    ]);
                }
            }

            if ($validated['is_favorite'] == false) {
                if ($favoriteCategoryGroup !== null) {
                    $favoriteCategoryGroup->delete();
                }
            }
            // $categoryGroup->is_favorite = $validated['is_favorite'];
        }

        if (isset($validated['is_hidden'])) {
            $hiddenCategoryGroup  = HiddenCategoryGroup::where('user_id',  Auth::user()->id)->where('category_group_id', $id)->first();

            if ($validated['is_hidden'] == true) {
                if ($hiddenCategoryGroup === null) {
                    HiddenCategoryGroup::create([
                        'user_id' =>  Auth::user()->id,
                        'category_group_id' => $id,
                    ]);
                }
            }

            if ($validated['is_hidden'] === false) {
                if ($hiddenCategoryGroup !== null) {
                    $hiddenCategoryGroup->delete();
                }
            }
            // $categoryGroup->is_favorite = $validated['is_hidden'];
        }
        $paramsForFiltering = self::NOT_AVAILABLE_FOR_MASS_ASSIGNMENT;

        if (Auth::user()->is_admin !== true) {
            $paramsForFiltering = array_merge($paramsForFiltering, self::NOT_AVAILABLE_FOR_NON_ADMIN);
            if ($categoryGroup->is_personal !== true) {
                // ||($categoryGroup->is_personal && $categoryGroup->user_id !== Auth::user()->id)
                $paramsForFiltering = array_merge($paramsForFiltering, self::NOT_AVAILABLE_FOR_NON_PERSONAL);
                // return response()->json(['message' => 'You do not have permission to update this resource'], 400);
            }
        }
        $validated = array_filter($validated, fn($key) => !in_array($key, $paramsForFiltering), ARRAY_FILTER_USE_KEY);

        if (count($validated) > 0) {
            $categoryGroup->update($validated);
        }
        return new CategoryGroupResource($categoryGroup);
    }
}
