<?php

namespace App\Http\Controllers;

use App\Http\Resources\DailyRationCollection;
use App\Http\Resources\DailyRationResource;
use App\Models\DailyRation;
use Illuminate\Http\Request;

class DailyRationController extends Controller
{
    public function index()
    {
        return new DailyRationCollection(DailyRation::all());
    }

    public function show(string $id)
    {
        return new DailyRationResource(DailyRation::find($id));
    }

    public function store(Request $request)
    {
        dd($request->products);
    }

    public function update(Request $request, string $id)
    {
        dd([
            'id' => $request->daily_ration,
            'prodcts' => $request->products,
        ]);
    }

    public function destroy(string $id) {}
}
