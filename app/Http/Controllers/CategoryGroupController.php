<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryGroupRequest;
use App\Http\Resources\CategoryGroupCollection;
use App\Http\Resources\CategoryGroupResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\HiddenCategoryGroup;
use App\Models\User;
use App\Models\FavoriteCategoryGroup;
use App\Models\FavoriteCategory;
use GuzzleHttp\Psr7\Message;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryGroupController extends Controller
{
    public function index()
    {
        $categoryGroups = CategoryGroup::whereEnabled()->whereAvailable(Auth::user() ? Auth::user()->id : null, 'category_groups');

        if (Auth::user()) {

            $categoryGroups = $categoryGroups->leftjoin('favorite_category_groups', function (JoinClause $join) {
                $join->on('category_groups.id', 'favorite_category_groups.category_group_id')
                    ->where('favorite_category_groups.user_id', Auth::user()->id);
            });

            $categoryGroups = $categoryGroups->leftjoin('hidden_category_groups', function (JoinClause $join) {
                $join->on('category_groups.id', 'hidden_category_groups.category_group_id')
                    ->where('hidden_category_groups.user_id', Auth::user()->id);
            });

            // $categoryGroups = $categoryGroups->leftjoin('favorite_category_groups', 'category_groups.id', 'favorite_category_groups.category_group_id')->where('favorite_category_groups.user_id', 11);
            // $categoryGroups = $categoryGroups->leftjoin('hidden_category_groups', 'category_groups.id', 'hidden_category_groups.category_group_id')->where('hidden_category_groups.user_id', 11);

            $categoryGroups = $categoryGroups->select('category_groups.*');
            $categoryGroups = $categoryGroups->selectRaw(
                'CASE WHEN favorite_category_groups.category_group_id is not null THEN true ELSE false END as is_favorite'
            );
            $categoryGroups = $categoryGroups->selectRaw(
                'CASE WHEN hidden_category_groups.category_group_id is not null THEN true ELSE false END as is_hidden'
            );
        }
        $categoryGroups = $categoryGroups->get();
        // dd($categoryGroups);
        // $categories = Category::whereEnabled()->whereAvailable(Auth::user() ? Auth::user()->id : null)->groupBy('category_group_id', 'id')->get();
        return new CategoryGroupCollection($categoryGroups);
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
        $categories = Category::where('category_group_id', $id)->whereEnabled()->whereAvailable(Auth::user()?->id)->get();
        // dd($categories);
        return new CategoryGroupResource($categorysGroup, $categories);
    }

    public function store(Request $request) {}

    public function update(CategoryGroupRequest $request, string $id)
    {
        $user = Auth::user();
        // $user = User::find(3);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $categoryGroup = CategoryGroup::find($id);

        if (!$categoryGroup) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $validated = $request->validated();

        // authorized user without admin permission can only change is_favorite value
        if ($user->is_admin === false) {
            // dump($validated);
            if (isset($validated['is_favorite'])) {
                $favoriteCategoryGroup = FavoriteCategoryGroup::where('user_id', $user->id)->where('category_groups_id', $id)->first();

                if ($validated['is_favorite'] === true) {
                    if ($favoriteCategoryGroup) {
                        return response()->json(['message' => 'Bad Request'], 400);
                    }
                    FavoriteCategoryGroup::create([
                        'user_id' => $user->id,
                        'category_groups_id' => $id,
                        'is_favorite' => true,
                    ]);
                }

                if ($validated['is_favorite'] == false) {
                    if (!$favoriteCategoryGroup) {
                        return response()->json(['message' => 'Bad Request'], 400);
                    }
                    $favoriteCategoryGroup->delete();
                }
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
            }

            return response()->json(new CategoryGroupResource($categoryGroup), 200);
        }

        //admin logic
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

        return  new CategoryResource($categoryGroup);
    }

    public function destroy(string $id) {}
}
