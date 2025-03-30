<?php

namespace App\Models;

use App\Builders\CustomBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryGroup extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryGroupFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'is_enabled',
        'is_personal',
    ];

    public function newEloquentBuilder($query): CustomBuilder
    {
        return new CustomBuilder($query);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
