<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyRationProduct extends Model
{
    /** @use HasFactory<\Database\Factories\DailyRationProductFactory> */
    use HasFactory;

    protected $fillable = [
        'daily_ration_id',
        'product_id',
        'diet_id',
        'time',
        // 'name',
        'quantity',
        // 'kcalory_per_unit',
        // 'proteins_per_unit',
        // 'carbohydrates_per_unit',
        // 'fats_per_unit',
    ];

    public function dailyRation(): BelongsTo
    {
        return $this->belongsTo(DailyRation::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
