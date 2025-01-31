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
        'time_of_use',
        'daily_ration_id',
        'product_id',
        'name',
        'quantity',
        'kcalory',
        'proteins',
        'carbohydrates',
        'fats',
    ];

    public function dailyRation(): BelongsTo
    {
        return $this->belongsTo(DailyRation::class);
    }
}
