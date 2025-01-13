<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'height',
        'weight',
    ];

    protected $hidden =[
        'created_at',
        'updated_at',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
