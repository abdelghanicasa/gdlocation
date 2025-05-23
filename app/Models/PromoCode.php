<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'code', 'discount', 'expires_at', 'usage_limit', 'active',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'active' => 'boolean',
    ];
}
