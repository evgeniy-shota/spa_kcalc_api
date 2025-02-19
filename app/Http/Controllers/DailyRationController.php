<?php

namespace App\Http\Controllers;

use App\Http\Resources\DailyRationCollection;
use App\Http\Resources\DailyRationResource;
use App\Models\DailyRation;
use App\Models\DailyRationProduct;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Undefined;

class DailyRationController extends Controller
{
    public function index()
    {
        return new DailyRationCollection(DailyRation::where('user_id', Auth::user()->id)->get());
    }

    public function show(string $id)
    {
        $user_id = Auth::user()->id;
        $ration = DailyRation::where('user_id', $user_id)->whereDate('created_at', $id)->get();
        // dd($userRations);
        // $ration = $userRations->get();
        if (count($ration) == 0) {

            // dd(date('Y-m-d'));
            return new DailyRationResource(DailyRation::create([
                'user_id' => $user_id,
                'date' => date('Y-m-d'),
            ]));
        }
        // dd($ration);
        return new DailyRationResource($ration[0]);
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
