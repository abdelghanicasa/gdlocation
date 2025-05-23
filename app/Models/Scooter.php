<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scooter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'modele',
        'statut',
        'disponible',
        'photo',
        'annee',
        'caracteristiques',
        'nbr_scooter',
        'prix_journalier'
    ];

    protected $casts = [
        'kilometrage' => 'integer',
        'nbr_scooter' => 'integer',
        'disponible' => 'integer',
    ];

    public function reservations()
    {
        return $this->hasMany(Calendar::class);
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/'.$this->photo) : asset('fe/img/default-scooter.png');
    }
    
        // app/Models/Scooter.php
    public function pricePeriods()
    {
        // return $this->hasMany(PricePeriod::class);
        return $this->hasMany(PricePeriod::class)->orderBy('start_date', 'asc');

    }

    public function getPriceForDate($startDate, $endDate)
    {
        $start = Carbon::parse($startDate)->format('Y-m-d');
        $end = Carbon::parse($endDate)->format('Y-m-d');
        $duration = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));

        // Trouver une période tarifaire qui couvre toute la plage
        $pricePeriod = $this->pricePeriods
            ->first(function ($period) use ($start, $end) {
                return $period->start_date <= $start && $period->end_date >= $end;
            });

        if ($pricePeriod) {
            $ranges = is_string($pricePeriod->price_ranges)
                ? json_decode($pricePeriod->price_ranges, true)
                : $pricePeriod->price_ranges;

            if (!empty($ranges)) {
                // Rechercher la bonne tranche de durée
                foreach ($ranges as $range) {
                    if ($duration >= (int)$range['min_days'] && $duration <= (int)$range['max_days']) {
                        return $range['price'];
                    }
                }

                // Sinon, on retourne le premier prix dispo
                return $ranges[0]['price'] ?? $pricePeriod->price;
            }
        }

        return null; // Aucun tarif trouvé
    }

    
public function getAveragePriceForDisplay($startDate, $endDate)
{
    $result = $this->calculateBreakdown($startDate, $endDate);
    $days = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;

    return $days > 0 ? round($result['total'] / $days) : null;
}


 
public function calculateBreakdown($startDate, $endDate)
{
    if (!$this->relationLoaded('pricePeriods')) {
        $this->load('pricePeriods');
    }

    $startDate = Carbon::parse($startDate);
    $endDate = Carbon::parse($endDate);
    $totalPrice = 0;
    $log = [];

    $currentDate = $startDate->copy();

    while ($currentDate <= $endDate) {
        $period = $this->pricePeriods->first(function ($p) use ($currentDate) {
            return Carbon::parse($p->start_date)->lte($currentDate) &&
                   Carbon::parse($p->end_date)->gte($currentDate);
        });

        if (!$period) {
            $defaultPrice = $this->default_price ?? 100;
            $totalPrice += $defaultPrice;
            $log[] = [
                'date' => $currentDate->toDateString(),
                'price' => $defaultPrice,
                'source' => 'default',
            ];
            $currentDate->addDay();
            continue;
        }

        $ranges = is_string($period->price_ranges)
            ? json_decode($period->price_ranges, true)
            : $period->price_ranges;

        $rangeEnd = min(Carbon::parse($period->end_date), $endDate);
        $rangeStart = $currentDate->copy();
        $rangeDays = $rangeStart->diffInDays($rangeEnd) + 1;

        $matchedPrice = collect($ranges)->first(function ($range) use ($rangeDays) {
            return $rangeDays >= $range['min_days'] && $rangeDays <= $range['max_days'];
        });

        $pricePerDay = $matchedPrice['price'] ?? ($period->price ?? $this->default_price ?? 100);
        $total = $pricePerDay * $rangeDays;
        $totalPrice += $total;

        $log[] = [
            'from' => $rangeStart->toDateString(),
            'to' => $rangeEnd->toDateString(),
            'days' => $rangeDays,
            'price_per_day' => $pricePerDay,
            'total' => $total,
            'period_id' => $period->id
        ];

        $currentDate = $rangeEnd->copy()->addDay();
    }

    return [
        'total' => $totalPrice,
        'breakdown' => $log
    ];
}




}