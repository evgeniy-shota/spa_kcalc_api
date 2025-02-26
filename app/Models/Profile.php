<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'date_of_birth',
        'height',
        'level_of_training',
        'level_of_daily_activity',
        'weight',
        'target_weight',
        'target_energy_value_ration',
    ];

    protected $hidden = [
        'created_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
