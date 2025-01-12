<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillible =[
        'name',
        'description',
        'type_of_load',
        'load_from_duration',
        'load_from_quantity',
        'energy_cost',
    ];
    /** @use HasFactory<\Database\Factories\ActivityFactory> */
    use HasFactory;
}
