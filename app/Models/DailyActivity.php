<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyActivity extends Model
{
    /** @use HasFactory<\Database\Factories\DailyActivityFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_id',
        'date',
        'time',
        'description',
        'duration_sec',
        'quantity',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
