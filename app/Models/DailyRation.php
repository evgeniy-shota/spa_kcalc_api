<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyRation extends Model
{
    /** @use HasFactory<\Database\Factories\DailyRationFactory> */
    use HasFactory;

    protected $fillable = [
        'time_of_use',
        'description',
        'products',
        'ration_summary',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
