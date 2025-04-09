<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return response()->json(['message' => 'Bad request'], 400);
        }
        $enabledVal = Auth::user() && Auth::user()->is_admin ? null : true;
        $product = Product::where('id', $id)->whereEnabled($enabledVal);

        if (Auth::user()) {
            if (Auth::user()->is_admin !== true) {
                $product = $product->whereAvailable(Auth::user()->id);
            }
        } else {
            $product = $product->whereAvailable(null);
        }
        $product = $product->first();

        if (!isset($product)) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return new ProductResource($product);
    }
}
