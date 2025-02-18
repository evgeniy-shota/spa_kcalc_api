<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    /** @use HasFactory<\Database\Factories\DishFactory> */
    use HasFactory;

    protected $fillable = [
        'dish_category_id',
        'user_id',
        'name',
        'is_personal',
        'is_enabled',
        'description',
        'quantity_to_calculate',
        'quantity',
        'kcalory',
        'proteins',
        'carbohydrates',
        'fats',
        'kcalory_per_unit',
        'proteins_per_unit',
        'carbohydrates_per_unit',
        'fats_per_unit',
        'data_source',
        'nutrients_and_vitamins',
        'thumbnail_image_path',
    ];
}
