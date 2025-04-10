<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductDestroyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return response()->json(['message' => 'Bad request'], 400);
        }
        $product = Product::find($id);

        if (!isset($product)) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        if (
            Auth::user()->is_admin ||
            ($product->is_enabled && $product->is_personal && ($product->user_id === Auth::user()->id))
        ) {
            $product->delete();
            return response()->json(['message' => 'Success'], 200);
        }
        return response()->json(['message' => 'You do not have permission to delete this resource'], 400);
    }
}
