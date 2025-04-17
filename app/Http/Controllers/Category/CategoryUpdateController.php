<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\FavoriteCategory;
use App\Models\HiddenCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryUpdateController extends Controller
{
    protected const NOT_AVAILABLE_FOR_NON_ADMIN = ['is_enabled', 'is_personal', 'user_id',];
    protected const NOT_AVAILABLE_FOR_NON_PERSONAL = [
        'category_group_id',
        'name',
        'description',
        'icon_path',
        'thumbnail_image_path',
    ];
    protected const NOT_AVAILABLE_FOR_MASS_ASSIGNMENT = ['is_favorite', 'is_hidden'];
    /**
     * Handle the incoming request.
     * 
     * If a non-administrator user attempts to update the model, 
     * the data included in NOT_AVAILABLE_FOR_NON_ADMIN 
     * will be deleted from the validated data.
     */
    public function __invoke(UpdateRequest $request, string $id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return response()->json(['message' => 'Bad request'], 400);
        }

        $category = Category::where('id', $id);

        if (Auth::user()->is_admin !== true) {
            $category = $category->whereEnabled()->whereAvailable(Auth::user()->id);
        }

        $category = $category->first();

        if (!isset($category)) {
            // ||($category->is_enabled !== true && Auth::user()->is_admin !== true)
            return response()->json(['message' => 'Resource for update not Found'], 404);
        }

        $validated = $request->validated();
        $isFavorite = FavoriteCategory::where('user_id', Auth::user()->id)
            ->where('category_id', $id)->first();
        $isHidden = HiddenCategory::where('user_id', Auth::user()->id)
            ->where('category_id', $id)->first();

        if (isset($validated['is_favorite'])) {

            if ($validated['is_favorite'] === true) {
                if ($isFavorite === null) {
                    $isFavorite = FavoriteCategory::create([
                        'user_id' => Auth::user()->id,
                        'category_id' => $id,
                    ]);
                }
            } else if ($validated['is_favorite'] === false) {
                if ($isFavorite !== null) {
                    $isFavorite->delete();
                    $isFavorite = null;
                }
            }
            // $category->is_favorite = $validated['is_favorite'];
            // unset($validated['is_favorite']);
        }

        if (isset($validated['is_hidden'])) {
            if ($validated['is_hidden'] === true) {
                if ($isHidden === null) {
                    $isHidden = HiddenCategory::create([
                        'user_id' => Auth::user()->id,
                        'category_id' => $id,
                    ]);
                }
            } else if ($validated['is_hidden'] === false) {
                if ($isHidden !== null) {
                    $isHidden->delete();
                    $isHidden = null;
                }
            }
            // $category->is_hidden = $validated['is_hidden'];
        }

        $paramsForFilter = self::NOT_AVAILABLE_FOR_MASS_ASSIGNMENT;

        if (Auth::user()->is_admin !== true) {
            $paramsForFilter = array_merge($paramsForFilter, self::NOT_AVAILABLE_FOR_NON_ADMIN);

            if ($category->is_personal !== true) {
                // ||($category->is_personal === true && $category->user_id !== Auth::user()->id)
                $paramsForFilter = array_merge($paramsForFilter, self::NOT_AVAILABLE_FOR_NON_PERSONAL);
                // return response()->json(['message' => 'You do not have permission to update this resource'], 400);
            }
        }

        $validated = array_filter($validated, function ($value, $key) use ($paramsForFilter) {
            if ($value === null) {
                return false;
            }
            return !in_array($key, $paramsForFilter);
        }, ARRAY_FILTER_USE_BOTH);

        if (count($validated) > 0) {
            $category->update($validated);
        }

        $category->is_favorite =  $isFavorite !== null ? true : false;
        $category->is_hidden =  $isHidden !== null ? true : false;

        return new CategoryResource($category);
    }
}
