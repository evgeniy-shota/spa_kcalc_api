<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DishCategory extends Model
{
    /** @use HasFactory<\Database\Factories\DishCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'is_personal',
        'is_enabled',
        'description',
        'thumbnail_image_path',
    ];
}
