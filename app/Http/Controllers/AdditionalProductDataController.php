<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryGroupCollection;
use App\Http\Resources\CountryOfManufactureCollection;
use App\Http\Resources\DataSourceCollection;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\CountryOfManufacture;
use App\Models\DataSource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdditionalProductDataController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user() ? Auth::user()->id : null;

        $categoriesGroup = CategoryGroup::whereEnabled()->whereAvailable($user_id)->get();
        $categories = Category::whereEnabled()->whereAvailable($user_id)->get();
        $countries = CountryOfManufacture::whereEnabled()->get();
        $dataSource = DataSource::where('is_enabled', true)->get();

        // $minCalory = ceil(Product::whereEnabled()->whereAvailable($user_id)->min('kcalory'));
        $minCalory = 0;
        $maxCalory = ceil(Product::whereEnabled()->whereAvailable($user_id)->max('kcalory'));
        // $minProteins = ceil(Product::whereEnabled()->whereAvailable($user_id)->min('proteins'));
        $minProteins = 0;
        $maxProteins = ceil(Product::whereEnabled()->whereAvailable($user_id)->max('proteins'));
        // $minCarbohydrates = ceil(Product::whereEnabled()->whereAvailable($user_id)->min('carbohydrates'));
        $minCarbohydrates = 0;
        $maxCarbohydrates = ceil(Product::whereEnabled()->whereAvailable($user_id)->max('carbohydrates'));
        // $minFats = ceil(Product::whereEnabled()->whereAvailable($user_id)->min('fats'));
        $minFats = 0;
        $maxFats = ceil(Product::whereEnabled()->whereAvailable($user_id)->max('fats'));

        return [
            'categoriesGroup' => new CategoryGroupCollection($categoriesGroup, null, null, $categories),
            // 'categories' => new CategoryCollection($categories),
            'country_of_manufactory' => new CountryOfManufactureCollection($countries),
            'data_source' => new DataSourceCollection($dataSource),
            'kcalory_limits' => ['min' => $minCalory, 'max' => $maxCalory],
            'proteins_limits' => ['min' => $minProteins, 'max' => $maxProteins],
            'carbohydrates_limits' => ['min' => $minCarbohydrates, 'max' => $maxCarbohydrates],
            'fats_limits' => ['min' => $minFats, 'max' => $maxFats],
        ];
    }
}
