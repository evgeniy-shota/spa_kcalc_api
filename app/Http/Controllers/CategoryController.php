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

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = new CategoryFilterChecker($request->toArray());
        // dd($data());

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

            $user_id = Auth::user() ? Auth::user()->id : -1;

            if ($category->is_personal == false || $category->user_id == $user_id) {

                $products = Product::where('category_id', $category->id)->whereEnabled()->whereAvailable($user_id)->orderBy('name', 'asc')->cursorPaginate();

                // where(
                //     function (Builder $q) use ($user_id) {
                //         $q->where('is_personal', false)->orWhere('user_id', $user_id);
                //     }
                // )->
                // return new CategoryResource($category);
                return new ProductCollection($products);
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
        dd($request);

        $newCategory = Category::create([
            'name' => $request->str('name'),
            'category_group_id' => $request->group_id,
            'user_id' => $request->user_id,
            'is_personal' => $request->is_personal,
            'is_enabled' => $request->boolean('is_enabled'),
        ]);

        return response()->json([$newCategory], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $updatedCategory = Category::updateOrCreate(
            ['id' => '$id'],
            ['name' => $request->name, 'is_enabled' => $request->is_enabled]
        );

        return response()->json($updatedCategory, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json(Category::destroy($id), 200);
    }
}
