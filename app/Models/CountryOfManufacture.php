<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryOfManufacture extends Model
{
    /** @use HasFactory<\Database\Factories\CountryOfManufactureFactory> */
    use HasFactory;

    protected $fillable = [
        'name_ru',
        'name_en',
        'flag_path',
        'is_enabled',
    ];
}
