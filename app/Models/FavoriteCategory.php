<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteCategory extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
    ];

    protected $table = 'favorite_categories';
}
