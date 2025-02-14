<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json(Category::all());

        if (Auth::user()) {
            $categories = Category::where('is_personal', false)->orWhere('user_id', Auth::user()->id)->orderBy('is_personal', 'desc')->get();
        } else {
            $categories = Category::where('is_personal', false)->where('is_visible', true)->get();
        }

        return new CategoryCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newCategory = Category::create([
            'name' => $request->str('name'),
            'is_visible' => $request->boolean('is_visible'),
        ]);
        return response()->json([$newCategory], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $category = Category::where('is_visible', true)->where('id', $id)->where('is_personal', false)->orWhere('user_id', $user_id)->get();
        $category = Category::find($id);

        if ($category && $category->is_visible) {

            $user_id = Auth::user() ? Auth::user()->id : null;

            if ($category->is_personal == false || $category->user_id == $user_id) {
                return new ProductCollection($category->products);
            }
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json(['message' => 'Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $updatedCategory = Category::updateOrCreate(
            ['id' => '$id'],
            ['name' => $request->name, 'is_vilible' => $request->is_visible]
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
