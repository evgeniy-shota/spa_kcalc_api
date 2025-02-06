<?php

namespace App\Http\Controllers;

use App\Models\DailyRation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    public function index()
    {
        $rations = User::find(3)->dailyRations;
        // dd($rations[0]->products->toArray()[0]);

        $ration_stat = [];

        for ($i = 0, $sizeI = count($rations); $i < $sizeI; $i++) {
            // $products[$i] = $rations[$i]->products;
            $products = $rations[$i]->products->toArray();
            // $ration_stat[$i] = [

            // ];

            for ($j = 0, $sizeJ = count($products); $j < $sizeJ; $j++) {
                $ration_stat[$i][$j] = [
                    'kcalory' => $products[$j]['kcalory_per_unit'] * $products[$j]['quantity'],
                    'proteins' => $products[$j]['proteins_per_unit'] * $products[$j]['quantity'],
                    'carbohydrates' => $products[$j]['carbohydrates_per_unit'] * $products[$j]['quantity'],
                    'fats' => $products[$j]['fats_per_unit'] * $products[$j]['quantity'],
                ];
            }

            // $ration_stat[$i] = [
            // 'kcalory' => $rations[$i]->products->toArray()[0]['kcalory_per_unit'],
            // 'kcalory' => $rations[$i]->products['kcalory_per_unit'] * $rations[$i]->products['quantity'],
            // 'proteins' => $rations[$i]->products['proteins_per_unit'] * $rations[$i]->products['quantity'],
            // 'carbohydrates' => $rations[$i]->products['carbohydrates_per_unit'] * $rations[$i]->products['quantity'],
            // 'fats' => $rations[$i]->products['fats_per_unit'] * $rations[$i]->products['quantity'],
            // ];
        }

        dd($ration_stat);
        return response()->json('index', 200);
    }

    public function show(string $resource)
    {
        return response()->json('show' . $resource, 200);
    }
}
