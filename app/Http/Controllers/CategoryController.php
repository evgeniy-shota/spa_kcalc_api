<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\CategoryCollection;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json(Category::all());
        return new CategoryCollection(Category::all());
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
        // return response()->json(Category::find($id)->products);
        return new CategoryCollection(Category::find($id)->products);
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
