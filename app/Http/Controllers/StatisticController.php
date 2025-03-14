<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatisticRequest;
use App\Models\DailyRation;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class StatisticController extends Controller
{

    protected function prepareRationsStatistic($rations, $timeSplits = null, $calculateForDay = true)
    {
        $ration_stat = [];

        for ($i = 0, $sizeI = count($rations); $i < $sizeI; $i++) {

            $products = $rations[$i]->products->toArray();

            $ration_stat[$i] = [
                'id' => $rations[$i]->id,
                //date format
                'date' => date_format($rations[$i]->date, 'd-m-Y'),
                'data' => $calculateForDay ?
                    $this->calculateStatisticsForDay($products, $timeSplits) :
                    $this->calculateStatisticsForProducts($products),
            ];
        }
        return $ration_stat;
    }

    protected function calculateStatisticsForProducts($products)
    {
        $ration_stat = [];

        for ($j = 0, $sizeJ = count($products); $j < $sizeJ; $j++) {
            $productData = Product::find($products[$j]['product_id']);
            $ration_stat[$j] = [
                'id' => $products[$j]['id'],
                'time' => $products[$j]['time'],
                'kcalory' => round($productData->kcalory_per_unit * $products[$j]['quantity'], 1),
                'proteins' => round($productData->proteins_per_unit * $products[$j]['quantity'], 1),
                'carbohydrates' => round($productData->carbohydrates_per_unit * $products[$j]['quantity'], 1),
                'fats' => round($productData->fats_per_unit * $products[$j]['quantity'], 1),
            ];
        }

        return $ration_stat;
    }

    protected function calculateStatisticsForDay($products, $timeSplits = null)
    {
        // if ($timeSplits) {
        // }

        $ration_stat = [
            'kcalory' => 0,
            'proteins' => 0,
            'carbohydrates' => 0,
            'fats' => 0,
        ];

        $splitedByTime = $timeSplits ? array_fill(0, count($timeSplits), $ration_stat) : [];

        // if ($timeSplits) {
        //     $splitedByTime = ;
        //     // array_map(fn($x) => $x = $ration_stat, $splitedByTime);
        // }

        // dump($splitedByTime);

        $res = &$ration_stat;
        // dump($timeSplits);
        for ($j = 0, $sizeJ = count($products); $j < $sizeJ; $j++) {

            if ($timeSplits) {
                if (key_exists(0, $timeSplits) && ($timeSplits[0][0] < $products[$j]['time']) && ($timeSplits[0][1] > $products[$j]['time'])) {
                    $res = &$splitedByTime[0];
                } else if (key_exists(1, $timeSplits) && ($timeSplits[1][0] < $products[$j]['time']) && ($timeSplits[1][1] > $products[$j]['time'])) {
                    $res = &$splitedByTime[1];
                } else if (key_exists(2, $timeSplits) && ($timeSplits[2][0] < $products[$j]['time']) && ($timeSplits[2][1] > $products[$j]['time'])) {
                    $res = &$splitedByTime[2];
                } else if (key_exists(3, $timeSplits) && ($timeSplits[3][0] < $products[$j]['time']) && ($timeSplits[3][1] > $products[$j]['time'])) {
                    $res = &$splitedByTime[3];
                } else if (key_exists(4, $timeSplits) && ($timeSplits[4][0] < $products[$j]['time']) && ($timeSplits[4][1] > $products[$j]['time'])) {
                    $res = &$splitedByTime[4];
                } else {
                    continue;
                }
            }

            $productData = Product::find($products[$j]['product_id']);

            $res['kcalory'] = round($productData->kcalory_per_unit * $products[$j]['quantity'] + $res['kcalory'], 2);
            $res['proteins'] = round($productData->proteins_per_unit * $products[$j]['quantity'] + $res['proteins'], 2);
            $res['carbohydrates'] = round($productData->carbohydrates_per_unit * $products[$j]['quantity'] + $res['carbohydrates'], 2);
            $res['fats'] = round($productData->fats_per_unit * $products[$j]['quantity'] + $res['fats'], 2);
        }

        if ($timeSplits) {
            return $splitedByTime;
        }

        return $ration_stat;
        // return array_map(fn($x) => round($x, 1), $res);
    }

    public function index(Request $request)
    {
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
            // dump($request->fromDay);
            $rations = DailyRation::where('user_id', 3)->where("date", '>=', $request->fromDay)->where("date", '<=', $request->toDay)->oldest()->get();

            return response()->json($this->prepareRationsStatistic($rations), 200);
        }

        return response()->json([], 404);
    }

    public function splitByTimeStat(StatisticRequest $request)
    {
        $validate = $request->validated();

        $rations = DailyRation::where('user_id', 3)->where("date", '>=', $validate['fromDay'])->where("date", '<=', $validate['toDay'])->oldest()->get();

        return response()->json($this->prepareRationsStatistic($rations, $validate['timeSplits'], true), 200);
    }

    // statistic for one day
    public function show(string $resource)
    {
        return response()->json('show' . $resource, 200);
    }
}
