<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    protected $table = 'FavoriteProduct';
}
