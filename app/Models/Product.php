<?php

namespace App\Models;

use App\Builders\CustomBuilder;
use App\Models\Traits\Filterable;
use App\Models\Traits\Sorterable;
use Illuminate\Cache\Events\RetrievingKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'type_id',
        'is_personal',
        'is_enabled',
        'is_abstract',
        'name',
        'thumbnail_image_name',
        'manufacturer_id',
        'country_of_manufacture_id',
        'trademark_id',
        'description',
        'units',
        'condition',
        'state',
        'quantity_to_calculate',
        'quantity',
        'composition',
        'kcalory',
        'proteins',
        'carbohydrates',
        'fats',
        'kcalory_per_unit',
        'proteins_per_unit',
        'carbohydrates_per_unit',
        'fats_per_unit',
        'nutrients_and_vitamins',
        'data_source',
    ];

    protected $hidden = [
        'created_at',
        // 'updated_at',
    ];
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, Searchable, Filterable, Sorterable;

    public function toSearchableArray(): array
    {
        $array = [
            'name' => $this->name
        ];

        return $array;
    }

    public function newEloquentBuilder($query): CustomBuilder
    {
        return new CustomBuilder($query);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function trademark(): BelongsTo
    {
        return $this->belongsTo(Trademark::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function datasource(): BelongsTo
    {
        return $this->belongsTo(DataSource::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
