<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DietProduct extends Model
{
    /** @use HasFactory<\Database\Factories\DietProductFactory> */
    use HasFactory;

    protected $fillable = [
        'diet_id',
        'product_id',
        // 'name',
        'quantity',
        // 'kcalory_per_unit',
        // 'proteins_per_unit',
        // 'carbohydrates_per_unit',
        // 'fats_per_unit',
    ];

    public function diet(): BelongsTo
    {
        return $this->belongsTo(Diet::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
