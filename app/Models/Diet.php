<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
