<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'horaires',
        'saison',
        'note',
        'logo',
        'social_networks',
        'tax_info',
    ];

    protected $casts = [
        'social_networks' => 'array', // Automatically cast JSON to array
    ];
}
