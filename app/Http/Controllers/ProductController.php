<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json(
        //     Product::all()
        // );
        return new ProductCollection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json('Unauthorized request...', 401);
        }

        $category = Category::create([
            'name' => $request->category['name'],
            'user_id' => $user->id,
            'description' => $request->category['description'],
            'is_personal' => true,
        ]);

        $nutrAndVit = $request->product['nutrients_and_vitamins'];
        // dump($nutrAndVit);

        $product = Product::create([
            'category_id' => $category['id'],
            'user_id' => $user->id,
            'is_personal' => true,
            'name' => $request->product['name'],
            'description' => $request->product['description'],
            'quantity_to_calculate' => $request->product['quantity'],
            'manufacturer' => $request->product['manufacturer'],
            'country_of_manufacture' => $request->product['country_of_manufacture'],
            'product_composition' => $request->product['composition'],
            'kcalory' => $request->product['kcalory'],
            'proteins' => $request->product['proteins'],
            'carbohydrates' => $request->product['carbohydrates'],
            'fats' => $request->product['fats'],
            'nutrients_and_vitamins' => count($nutrAndVit) > 0 ? json_encode($nutrAndVit, JSON_UNESCAPED_UNICODE) : null,
        ]);

        // dump($category);
        // dump($product);

        return response()->json([
            'product' => $product,
            'category' => $category,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return response()->json(
        //     Product::find($id)
        // );
        // dd(Product::find($id));
        return new ProductResource(Product::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
