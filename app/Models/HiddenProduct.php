<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiddenProduct extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    protected $table='hidden_products';
}
