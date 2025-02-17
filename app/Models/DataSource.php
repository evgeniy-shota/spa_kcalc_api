<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataSource extends Model
{
    /** @use HasFactory<\Database\Factories\DataSourceFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'name_orig',
        'description_ru',
        'description_en',
        'citation',
        'thumbnail_image_name',
        'is_enabled',
    ];

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
