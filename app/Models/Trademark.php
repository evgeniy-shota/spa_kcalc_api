<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trademark extends Model
{
    /** @use HasFactory<\Database\Factories\TrademarkFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logo_path',
        'is_visible',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
