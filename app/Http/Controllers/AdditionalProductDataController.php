<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CountryOfManufactureCollection;
use App\Http\Resources\DataSourceCollection;
use App\Models\Category;
use App\Models\CountryOfManufacture;
use App\Models\DataSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdditionalProductDataController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user() ? Auth::user()->id : null;

        $categories = Category::whereEnabled()->whereAvailable($user_id)->get();
        $countries = CountryOfManufacture::whereEnabled()->get();
        $dataSource = DataSource::where('is_enabled', true)->get();
        return [
            'categories' => new CategoryCollection($categories),
            'country_of_manufactory' => new CountryOfManufactureCollection($countries),
            'data_source' => new DataSourceCollection($dataSource),
        ];
    }
}
