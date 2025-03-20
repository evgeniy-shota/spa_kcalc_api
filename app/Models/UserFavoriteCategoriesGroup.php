<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavoriteCategoriesGroup extends Model
{
    protected $fillable = [
        'user_id',
        'category_groups_id',
    ];
}
