<?php

namespace App\Models;

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
        'is_visible',
        'name',
        'manufacturer',
        'country_of_manufacture',
        'trademark_id',
        'description',
        'units_of_measurement',
        'quantity_to_calculate',
        'quantity',
        'product_composition',
        'kcalory',
        'proteins',
        'carbohydrates',
        'fats',
        'nutrients_and_vitamins',
        'tag_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, Searchable;

    public function toSearchableArray(): array
    {
        $array = [
            'name' => $this->name
        ];

        return $array;
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

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
