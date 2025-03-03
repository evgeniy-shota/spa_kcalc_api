<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryOfManufactureCollection;
use App\Models\CountryOfManufacture;
use Illuminate\Http\Request;

class CountryOfManufactureController extends Controller
{
    public function index()
    {
        $countries = CountryOfManufacture::whereEnabled()->get();
        return new CountryOfManufactureCollection($countries);
    }
}
