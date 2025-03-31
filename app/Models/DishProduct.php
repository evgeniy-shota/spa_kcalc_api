<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DishProduct extends Model
{
    /** @use HasFactory<\Database\Factories\DishProductFactory> */
    use HasFactory;

    protected $fillable = [
        'dish_id',
        'product_id',
        'type_food_processing_id',
        'quantity',
    ];
}
