<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRationProduct extends Model
{
    /** @use HasFactory<\Database\Factories\DailyRationProductFactory> */
    use HasFactory;

    protected $fillable = [
        'daily_ration_id',
        'product_id',
        'name',
        'quantity',
        'kcalory',
        'proteins',
        'carbohydrates',
        'fats',
    ];
}
