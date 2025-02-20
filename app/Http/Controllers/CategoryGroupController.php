<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryGroupCollection;
use App\Http\Resources\CategoryGroupResource;
use App\Models\CategoryGroup;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;

class CategoryGroupController extends Controller
{
    public function index()
    {
        $categoriesGroups = CategoryGroup::where('is_enabled', true)->get();

        return new CategoryGroupCollection($categoriesGroups);
    }

    public function show(string $id)
    {

        $categorysGroup = CategoryGroup::find($id);
        // dd($categorysGroup);

        if (!isset($categorysGroup) || !$categorysGroup->is_enabled) {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        return new CategoryGroupResource($categorysGroup);
    }

    public function store(Request $request) {}

    public function update(Request $request, string $id) {}

    public function destroy() {}
}
