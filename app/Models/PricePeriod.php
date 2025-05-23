<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricePeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'scooter_id',
        'start_date',
        'end_date',
        'price',
        'period_name',
        'min_days',
        'max_days',
        'price_ranges',
    ];

    protected $casts = [
        'price_ranges' => 'array',
    ];

    public function scooter()
    {
        return $this->belongsTo(Scooter::class);
    }
}
