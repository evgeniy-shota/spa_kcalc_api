<?php

namespace App\Http\Controllers;

use App\Http\Resources\SearchCollection;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $products = Product::search($request->queryString)->get();


        return new SearchCollection($products);

        return response()->json([
            'result' => $products,
        ], 200);
    }
}
