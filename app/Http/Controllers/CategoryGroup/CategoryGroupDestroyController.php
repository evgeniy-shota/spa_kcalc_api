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
        $categoryGroup = CategoryGroup::find($id);

        if (
            $categoryGroup === null ||
            ($categoryGroup->is_enabled !== true && Auth::user()->is_admin !== true)
        ) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        if (
            Auth::user()->is_admin === true ||
            ($categoryGroup->is_personal === true && $categoryGroup->user_id === Auth::user()->id)
        ) {
            $categoryGroup->delete();
            return new CategoryGroupRequest($categoryGroup);
        } else {
            return response()->json(['message' => 'You do not have permission to delete this resource'], 400);
        }
        return response()->json(['message' => 'Bad request'], 400);
    }
}
