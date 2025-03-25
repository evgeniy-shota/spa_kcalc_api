<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiddenCategory extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
    ];
}
