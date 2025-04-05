<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteCategoryGroup extends Model
{
    protected $fillable = [
        'user_id',
        'category_group_id',
    ];

    protected $table='favorite_category_groups';
}
