<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiddenCategoryGroup extends Model
{
    protected $fillable = [
        'user_id',
        'category_group_id',
    ];
}
