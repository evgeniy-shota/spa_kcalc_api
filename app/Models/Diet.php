<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Diet extends Model
{
    protected $fillable = [
        'name',
        'description',
        'products',
        'summ_val',
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
