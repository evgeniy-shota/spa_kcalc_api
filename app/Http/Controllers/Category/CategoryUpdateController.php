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
    /**
     * Handle the incoming request.
     * 
     * If a non-administrator user attempts to update the model, 
     * the data included in NOT_AVAILABLE_FOR_NON_ADMIN 
     * will be deleted from the validated data.
     */
    public function __invoke(UpdateRequest $request, string $id)
    {
        $category = Category::find($id);

        if (
            $category === null ||
            ($category->is_enabled !== true && Auth::user()->is_admin !== true)
        ) {
            return response()->json(['message' => 'Resource for update not Found'], 404);
        }
        $validated = $request->validated();

        if (Auth::user()->is_admin !== true) {
            if (
                $category->is_personal !== true ||
                ($category->is_personal === true && $category->user_id !== Auth::user()->id)
            ) {
                return response()->json(['You do not have permission to update this resource'], 400);
            }
            $validated = array_filter($validated, fn($item) => !in_array($item, self::NOT_AVAILABLE_FOR_NON_ADMIN));
        }
        $category->update([
            $validated
        ]);

        if (isset($validated['is_favorite'])) {
            $isFavorite = FavoriteCategory::where('user_id', Auth::user()->id)->where('category_id', $id)->first();

            if ($validated['is_favorite'] === true) {
                if ($isFavorite === null) {
                    FavoriteCategory::create([
                        'user_id' => Auth::user()->id,
                        'category_id' => $id,
                    ]);
                }
            } else if ($validated['is_favorite'] === false) {
                if ($isFavorite !== null) {
                    $isFavorite->delete();
                }
            }
            $category->is_favorite = $validated['is_favorite'];
        }

        if (isset($validated['is_hidden'])) {
            $isHidden = HiddenCategory::where('user_id', Auth::user()->id)->where('category_id', $id)->first();
            if ($validated['is_hidden'] === true) {
                if ($isHidden === null) {
                    HiddenCategory::create([
                        'user_id' => Auth::user()->id,
                        'category_id' => $id,
                    ]);
                }
            } else if ($validated['is_hidden'] === false) {
                if ($isHidden !== null) {
                    $isHidden->delete();
                }
            }
            $category->is_hidden = $validated['is_hidden'];
        }
        return new CategoryResource($category);
    }
}
