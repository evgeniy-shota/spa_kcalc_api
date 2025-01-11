<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{

    protected $fillible =[
        'category_id',
        'name',
        'product_composition',
        'description',
        'calory',
        'protein',
        'carbohydrates',
        'fat',
        'nutrients_and_vitamins',
        'is_visible',
    ];
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
