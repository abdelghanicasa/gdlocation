<?php

namespace App\Http\Controllers;

use App\Models\PricePeriod;
use App\Models\Scooter;
use Illuminate\Http\Request;

class PricePeriodController extends Controller
{
    // public function 1_index()
    // {
    //     $pricePeriods = PricePeriod::with('scooter')->get();
    //     return view('admin.pages.price_periods.index', compact('pricePeriods'));
    // }

    public function index()
    {
        // Récupérer les scooters avec leurs périodes de tarifs associées
        $scootersWithPeriods = Scooter::with('pricePeriods')->get();

        return view('admin.pages.price_periods.index', compact('scootersWithPeriods'));
    }


    public function create()
    {
        $scooters = Scooter::all();
        return view('admin.pages.price_periods.create', compact('scooters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'scooter_id' => 'required|exists:scooters,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'period_name' => 'required|string|max:255',
            'price_ranges' => 'required|array|min:1',
            'price_ranges.*.min_days' => 'required|integer|min:1',
            'price_ranges.*.max_days' => 'required|integer|gte:price_ranges.*.min_days',
            'price_ranges.*.price' => 'required|numeric|min:0',
            
        ]);
    
        PricePeriod::create([
            'scooter_id'   => $request->scooter_id,
            'start_date'   => $request->start_date,
            'end_date'     => $request->end_date,
            'period_name'  => $request->period_name,
            'price'        => 0, // Prix principal optionnel
            'price_ranges' => $request->price_ranges,
        ]);
    
        return redirect()->route('price_periods.index')->with('success', 'Période de prix enregistrée avec ses plages.');
    }
    
    

    public function edit(PricePeriod $pricePeriod)
    {
        $scooters = Scooter::all();
    
        // Décoder le JSON en tableau associatif
        $priceRanges = is_array($pricePeriod->price_ranges)
            ? $pricePeriod->price_ranges
            : json_decode($pricePeriod->price_ranges, true) ?? [];        //dd($priceRanges);
            
                return view('admin.pages.price_periods.edit', compact('pricePeriod', 'scooters', 'priceRanges'));
    }
    

public function update(Request $request, PricePeriod $pricePeriod)
{
    $request->validate([
        'scooter_id' => 'required|exists:scooters,id',
        'period_name' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'price_ranges' => 'required|array',
        'price_ranges.*.min_days' => 'required|numeric',
        'price_ranges.*.max_days' => 'required|numeric',
        'price_ranges.*.price' => 'required|numeric',
    ]);

    $pricePeriod->update([
        'scooter_id' => $request->scooter_id,
        'period_name' => $request->period_name,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'price' => collect($request->price_ranges)->min('price'), // optionnel
        'price_ranges' => json_encode($request->price_ranges),
    ]);

    return redirect()->route('price_periods.edit', $pricePeriod->id)->with('success', 'Période mise à jour avec succès');
}



    public function destroy(PricePeriod $pricePeriod)
    {
        $pricePeriod->delete();
        return redirect()->route('price_periods.index')->with('success', 'Période de prix supprimée.');
    }
}
