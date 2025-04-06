<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        $category = Category::find($id);

        if ($category === null) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        if ($category->is_enabled !== true && (Auth::user() === null || Auth::user()->is_admin !== true)) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        if (
            $category->is_personal === true &&
            (Auth::user() === null || $category->user_id !== Auth::user()->id || Auth::user()->is_admin !== true)
        ) {
            return response()->json(['message' => 'You don\'t have permission'], 400);
        }

        return new CategoryResource($category);
    }
}
