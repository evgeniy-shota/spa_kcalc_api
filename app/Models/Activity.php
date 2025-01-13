<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable =[
        'name',
        'description',
        'type_of_load',
        'load_from_duration',
        'load_from_quantity',
        'energy_cost',
    ];

    protected $hidden =[
        'created_at',
        'updated_at',
    ];
    /** @use HasFactory<\Database\Factories\ActivityFactory> */
    use HasFactory;
}
