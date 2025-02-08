<?php

namespace App\Http\Controllers;

use App\Models\DailyRation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{

    protected function prepareRationsStatistic($rations, $calculateForDay = true)
    {
        $ration_stat = [];

        for ($i = 0, $sizeI = count($rations); $i < $sizeI; $i++) {

            $products = $rations[$i]->products->toArray();

            $ration_stat[$i] = [
                'id' => $rations[$i]->id,
                //date format
                'date' => date_format($rations[$i]->created_at, 'd-m-Y'),
                'data' => $calculateForDay ?
                    $this->calculateStatisticsForDay($products) :
                    $this->calculateStatisticsForProducts($products),
            ];
        }
        return $ration_stat;
    }

    protected function calculateStatisticsForProducts($products)
    {
        $ration_stat = [];

        for ($j = 0, $sizeJ = count($products); $j < $sizeJ; $j++) {
            $ration_stat[$j] = [
                'id' => $products[$j]['id'],
                'time' => $products[$j]['time_of_use'],
                'kcalory' => round($products[$j]['kcalory_per_unit'] * $products[$j]['quantity'], 1),
                'proteins' => round($products[$j]['proteins_per_unit'] * $products[$j]['quantity'], 1),
                'carbohydrates' => round($products[$j]['carbohydrates_per_unit'] * $products[$j]['quantity'], 1),
                'fats' => round($products[$j]['fats_per_unit'] * $products[$j]['quantity'], 1),
            ];
        }

        return $ration_stat;
    }

    protected function calculateStatisticsForDay($products)
    {
        $ration_stat = [
            'kcalory' => 0,
            'proteins' => 0,
            'carbohydrates' => 0,
            'fats' => 0,
        ];

        for ($j = 0, $sizeJ = count($products); $j < $sizeJ; $j++) {

            $ration_stat['kcalory'] += $products[$j]['kcalory_per_unit'] * $products[$j]['quantity'];
            $ration_stat['proteins'] += $products[$j]['proteins_per_unit'] * $products[$j]['quantity'];
            $ration_stat['carbohydrates'] += $products[$j]['carbohydrates_per_unit'] * $products[$j]['quantity'];
            $ration_stat['fats'] += $products[$j]['fats_per_unit'] * $products[$j]['quantity'];
        }

        return array_map(fn($x) => round($x, 1), $ration_stat);
    }

    public function index(Request $request)
    {
        // $user_id = Auth::user()->id;
        $user_id = 3;

        if ($request->fromMonth != null) {

            dump(date_format(date_create($request->toMonth), 'U') - date_format(date_create($request->fromMonth), 'U'));
            $rations = [];
            return response()->json($this->prepareRationsStatistic($rations), 200);
        }

        if ($request->fromWeek != null) {

            dump(date_format(date_create($request->toWeek), 'U') - date_format(date_create($request->fromWeek), 'U'));
            $rations = [];
            return response()->json($this->prepareRationsStatistic($rations), 200);
        }

        if ($request->fromDay != null) {
            // dump();
            $rations = DailyRation::where('user_id', 3)->where("created_at", '>=', $request->fromDay)->where("created_at", '<=', $request->toDay)->oldest()->get();

            return response()->json($this->prepareRationsStatistic($rations), 200);
        }

        // $ration_statistics = $this->prepareRationsStatistic($rations);
        // dd($ration_stat);
        return response()->json([], 404);
    }

    // statistic for one day
    public function show(string $resource)
    {
        return response()->json('show' . $resource, 200);
    }
}
