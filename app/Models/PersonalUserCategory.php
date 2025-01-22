<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonalUserCategory extends Model
{
    /** @use HasFactory<\Database\Factories\PersonalUserCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_visible',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(PersonalUserProduct::class);
    }
}
