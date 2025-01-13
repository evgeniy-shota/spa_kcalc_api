<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{

    protected $fillable =[
        'category_id',
        'name',
        'product_composition',
        'description',
        'calory',
        'proteins',
        'carbohydrates',
        'fats',
        'nutrients_and_vitamins',
        'is_visible',
    ];

    protected $hidden =[
        'created_at',
        'updated_at',
    ];
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
