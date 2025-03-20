<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryGroupRequest;
use App\Http\Resources\CategoryGroupCollection;
use App\Http\Resources\CategoryGroupResource;
use App\Models\CategoryGroup;
use App\Models\User;
use App\Models\UserFavoriteCategoriesGroup;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryGroupController extends Controller
{
    public function index()
    {
        $categoriesGroups = CategoryGroup::whereEnabled()->get();

        return new CategoryGroupCollection($categoriesGroups);
    }

    public function show(string $id)
    {

        $categorysGroup = CategoryGroup::find($id);
        // dd($categorysGroup);

        if (!isset($categorysGroup) || !$categorysGroup->is_enabled) {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        return new CategoryGroupResource($categorysGroup);
    }

    public function store(Request $request) {}

    public function update(CategoryGroupRequest $request, string $id)
    {
        // $user = Auth::user() ? Auth::user() : null;
        $user = User::find(3);
        // if (!isset($user)) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

        $validated = $request->validated();

        // authorized user without admin permission can only change is_favorite value
        if ($user->is_admin === false) {
            if (isset($validated['is_favorite'])) {
                $favoriteCategoryGroup = UserFavoriteCategoriesGroup::where('user_id', $user->id)->where('category_groups_id', $id)->first();

                if ($validated['is_favorite'] == true && !isset($favoriteCategoryGroup)) {
                    UserFavoriteCategoriesGroup::create([
                        'user_id' => $user->id,
                        'category_groups_id' => $id,
                        'is_favorite' => true,
                    ]);
                    return response()->json(['message' => 'Success'], 200);
                }

                if ($validated['is_favorite'] == false && isset($favoriteCategoryGroup)) {

                    UserFavoriteCategoriesGroup::find($favoriteCategoryGroup->id)->delete();

                    return response()->json(['message' => 'Success'], 200);
                }
            }
            return response()->json(['message' => 'Bad Request'], 402);
        }

        //admin logic
        $categoryGroup = CategoryGroup::find($id);
        // $categoryGroup = CategoryGroup::where('id', $id)->update([
        //     'name' => $validated['name'],
        //     'description' => $validated['description'],
        //     'is_enabled' => $validated['is_enabled'],
        // ]);

        if ($validated['name']) {
            $categoryGroup->name = $validated['name'];
        }

        if ($validated['description']) {
            $categoryGroup->description = $validated['description'];
        }

        if ($validated['is_enabled']) {
            $categoryGroup->is_enabled = $validated['is_enabled'];
        }

        $categoryGroup->save();

        return response()->json([$categoryGroup], 200);
    }

    public function destroy() {}
}
