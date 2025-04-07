<?php

namespace App\Http\Controllers\CategoryGroup;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryGroupRequest;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryGroupDestroyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return response()->json(['message' => 'Bad request'], 400);
        }
        $categoryGroup = CategoryGroup::where('id', $id);

        if (Auth::user()->id_admin !== true) {
            $categoryGroup = $categoryGroup->whereEnabled()->whereAvailable(Auth::user()->id);
        }
        $categoryGroup = $categoryGroup->first();

        if (!isset($categoryGroup)) {
            // ||($categoryGroup->is_enabled !== true && Auth::user()->is_admin !== true)
            return response()->json(['message' => 'Not Found'], 404);
        }

        if (
            Auth::user()->is_admin === true ||
            ($categoryGroup->is_personal === true && $categoryGroup->user_id === Auth::user()->id)
        ) {
            $categoryGroup->delete();
            return response()->json(['message' => 'Success'], 200);
        } else {
            return response()->json(['message' => 'You do not have permission to delete this resource'], 400);
        }
        return response()->json(['message' => 'Bad request'], 400);
    }
}
