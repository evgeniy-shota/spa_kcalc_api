<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryGroup extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryGroupFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_enabled',
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
