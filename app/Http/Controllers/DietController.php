<?php

namespace App\Http\Controllers;

use App\Http\Resources\DietCollection;
use App\Http\Resources\DietResource;
use App\Models\Diet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DietController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        return new DietCollection($currentUser->diets);
    }

    public function show(string $id)
    {

        $currentUser = Auth::user();
        // dump($currentUser->diets->where('id',$id));
        return new DietResource($currentUser->diets->find($id));
    }

    public function store(Request $request) {}

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}
