<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    protected $fillable =[];
    protected $hiddden = [];
    /** @use HasFactory<\Database\Factories\DietFactory> */
    use HasFactory;
}
