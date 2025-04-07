<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryDestroyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return response()->json(['message' => 'Bad request'], 400);
        }
        $category = Category::where('id', $id);

        if (Auth::user()->is_admin !== true) {
            $category = $category->whereEnabled()->whereAvailable(Auth::user()->id);
        }
        $category = $category->first();

        if (!isset($category)) {
            // ||($category->is_enabled !== true && Auth::user()->is_admin !== true)

            return response()->json(['message' => 'Not Found'], 404);
        }

        if (
            Auth::user()->is_admin ||
            ($category->is_personal === true && $category->user_id === Auth::user()->id)
        ) {
            $category->delete();
            return response()->json(['message' => 'Success'], 200);
        } else {
            return response()->json(['message' => 'You do not have permission to delete this resource'], 400);
        }
        return response()->json(['message' => 'Bad request'], 400);
    }
}
