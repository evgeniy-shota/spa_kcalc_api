<?php

namespace App\Http\Controllers;

use App\Http\Resources\DietCollection;
use App\Http\Resources\PersonalUserProductCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\SearchCollection;
use App\Models\Diet;
use App\Models\PersonalUserProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $products = Product::search($request->searchQuery)->get();

        // add condition to where user_id=auth::user
        // add condition 
        // Diet::search($request->searchQuery)->where('user_id',...)->get();
        $diets = Diet::search($request->searchQuery)->get();

        return [
            'products' => new ProductCollection($products),
            'diets' => new DietCollection($diets),
            'searchQuery' => $request->searchQuery,
        ];

        // return new SearchCollection([
        //     'products' => $products,
        //     'personalProducts' => $personalProducts,
        //     'diets' => $diets
        // ]);

        // return new SearchCollection($products);
    }
}
