<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Diet extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'is_enabled',
        'is_personal',
        'description',
        // 'kcalory',
        // 'proteins',
        // 'carbohydrates',
        // 'fats',
        'thumbnail_image_path',
    ];
    // protected $hiddden = [];
    /** @use HasFactory<\Database\Factories\DietFactory> */
    use HasFactory, Searchable;

    public function toSearchableArray(): array
    {
        $array = [
            'name' => $this->name,
        ];

        return $array;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
