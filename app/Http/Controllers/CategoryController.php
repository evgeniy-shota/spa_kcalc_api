<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use App\Builders\CustomBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\CategoryRequest;
use App\Http\Filters\CategoryFilter;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;


use App\Http\CustomValidators\CategoryFilterChecker;
use App\Models\HiddenCategory;
use App\Models\UserFavoriteCategory;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = new CategoryFilterChecker($request->toArray());

        $validatedData = Validator::make($data(), [
            'name' => 'nullable|string',
            'isPersonal' => 'nullable|boolean'
        ]);

        $data = $validatedData->validated();
        // dump(app());
        // сделат ьпоиск независамым от регистра
        $filter = app()->make(CategoryFilter::class, ['queryParams' => array_filter($validatedData->validated())]);

        // $categories = Category::where('is_enabled', true)->filter($filter)->get();

        if (Auth::user()) {
            $categories = Category::whereEnabled()->whereAvailable(Auth::user()->id)->filter($filter)->orderBy('is_personal', 'desc')->get();
        } else {
            $categories = Category::whereEnabled()->whereAvailable()->filter($filter)->get();
        }

        return new CategoryCollection($categories);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $category = Category::where('is_visible', true)->where('id', $id)->where('is_personal', false)->orWhere('user_id', $user_id)->get();
        $category = Category::find($id);

        if ($category && $category->is_enabled) {

            $user_id = Auth::user() ? Auth::user()->id : null;

            if ($category->is_personal == false || $category->user_id == $user_id) {

                $products = Product::where('category_id', $category->id)->whereEnabled()->whereAvailable($user_id)->orderBy('name', 'asc')->cursorPaginate();

                // where(
                //     function (Builder $q) use ($user_id) {
                //         $q->where('is_personal', false)->orWhere('user_id', $user_id);
                //     }
                // )->
                // return new CategoryResource($category);
                $category->categoryProducts = $products;
                return new CategoryResource($category);
                // return response()->json(['data' => new CategoryResource($category), 'category_data' => new ProductCollection($products)], 200);
            }
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json(['message' => 'Not Found'], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        // dd($request);
        $validated = $request->validated();

        $newCategory = Category::create([
            'user_id' => Auth::user()->id,
            'name' => $validated['name'],
            'category_group_id' => $validated['category_group_id'],
            'description' => $validated['description'],
            'is_personal' => $validated->is_personal ?? true,
            // 'is_enabled' => $validated->boolean('is_enabled'),
        ]);

        return response()->json(new CategoryResource($newCategory), 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        // dd($request);
        $user = Auth::user();

        if (!isset($user)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validate = $request->validated();
        $category = Category::find($id);

        if (!isset($category)) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        if (
            $user->is_admin ||
            ($category->is_enabled && $user->id === $category->user_id && $category->is_personal === true)
        ) {

            if (array_key_exists('category_group_id', $validate)) {
                $category->category_group_id = $validate['category_group_id'];
            }

            if (array_key_exists('name', $validate)) {
                $category->name = $validate['name'];
            }

            if (array_key_exists('description', $validate)) {
                $category->description = $validate['description'];
            }

            if (array_key_exists('icon_path', $validate)) {
                $category->icon_path = $validate['icon_path'];
            }

            if (array_key_exists('thumbnail_image_path', $validate)) {
                $category->thumbnail_image_path = $validate['thumbnail_image_path'];
            }

            if ($user->is_admin) {
                if (array_key_exists('is_personal', $validate)) {
                    $category->is_personal = $validate['is_personal'];
                }

                if (array_key_exists('is_enabled', $validate)) {
                    $category->is_enabled = $validate['is_enabled'];
                }
            }
            $category->save();
        }

        if (array_key_exists('is_favorite', $validate)) {
            $favoriteCategory = UserFavoriteCategory::where('user_id', $user->id)->where('category_id', $id)->first();

            if ($validate['is_favorite'] === true) {
                if (isset($favoriteCategory)) {
                    return response()->json(['message' => 'Bad Request'], 400);
                }
                UserFavoriteCategory::create([
                    'user_id' => $user->id,
                    'category_id' => $id,
                ]);
            }

            if ($validate['is_favorite'] === false) {
                if (!isset($favoriteCategory)) {
                    return response()->json(['message' => 'Bad Request'], 400);
                }
                $favoriteCategory->delete();
            }
        }

        if (isset($validate['is_hidden'])) {
            $hiddenCategory = HiddenCategory::where('user_id', $user->id)->where('category_id', $id)->first();

            if ($validate['is_hidden'] === true) {
                if ($hiddenCategory) {
                    return response()->json(['message' => 'Bad Request'], 400);
                }
                HiddenCategory::create([
                    'user_id' => $user->id,
                    'category_id' => $id,
                ]);
            }

            if ($validate['is_hidden'] === false) {
                if (!$hiddenCategory) {
                    return response()->json(['message' => 'Bad Request'], 400);
                }
                $hiddenCategory->delete();
            }
        }
        return new CategoryResource($category);
        // return response()->json(['message' => 'Ok', 'data' => new CategoryResource($category)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd('try to destroy');

        return response()->json(Category::destroy($id), 200);
    }
}
