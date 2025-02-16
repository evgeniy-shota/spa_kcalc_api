<?php

namespace App\Models;

use Egulias\EmailValidator\Result\Reason\UnclosedComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Workbench\App\Models\User;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'is_enabled',
        'is_personal',
        'name',
        'description',
        'type_of_load',
        'duration_sec_to_calculate',
        'quantity_to_calculate',
        'energy_cost',
        'energy_cost_per_unit',
        'thumbnail_image_path',
    ];

    protected $hidden = [
        'created_at',
        // 'updated_at',
    ];
    /** @use HasFactory<\Database\Factories\ActivityFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activityCategory(): BelongsTo
    {
        return $this->belongsTo(ActivityCategory::class);
    }

    public function dailyActivities(): HasMany
    {
        return $this->hasMany(DailyActivity::class);
    }
}
