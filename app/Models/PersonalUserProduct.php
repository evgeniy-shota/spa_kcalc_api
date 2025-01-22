<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalUserProduct extends Model
{
    /** @use HasFactory<\Database\Factories\PersonalUserProductFactory> */
    use HasFactory;

    protected $fillable = [
        'personal_user_category_id',
        'name',
        'product_composition ',
        'description',
        'calory',
        'protein',
        'carbohydrates',
        'fat',
        'nutrients_and_vitamins ',
        'is_visible',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PersonalUserCategory::class);
    }
}
