<?php

namespace App\Http\Controllers;

use App\Http\Resources\DailyRationCollection;
use App\Http\Resources\DailyRationResource;
use App\Models\DailyRation;
use App\Models\DailyRationProduct;
use Illuminate\Http\Request;
use Mockery\Undefined;

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

        $ration = DailyRation::updateOrCreate(['id' => $id], $request->ration);

        DailyRationProduct::destroy($request->productsForDelete);

        foreach ($request->products as $product) {
            if (array_key_exists('id', $product)) {
                DailyRationProduct::updateOrCreate(['id' => $product['id']], $product);
            } else {
                DailyRationProduct::create($product);
            }
        }
        return new DailyRationResource($ration);
    }

    public function destroy(string $id) {}
}
