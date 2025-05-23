<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Scooter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Date actuelle
        $now = Carbon::now();
    
        // Montant total pour réservations confirmées CE MOIS-CI
        $totalConfirmée = Calendar::where('etat_paiement', 'confirmé')
            // ->where('etat_reservation', 'confirmée')
            ->whereMonth('start', $now->month)
            ->whereYear('end', $now->year)
            ->sum('montant');
    
        // Montant total pour réservations en cours CE MOIS-CI
        $totalEnCours = Calendar::where('etat_paiement', 1)
            // ->where('etat_reservation', 'en_cours')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('montant');
        // dd($totalEnCours);
        $today = Carbon::today()->toDateString();
        // IDs des scooters déjà réservés aujourd’hui
        // $nbrScootersDisponibles = Calendar::whereDate('start', $today)
        //                             ->where('etat_reservation', 'confirmée')
        //                             ->pluck('scooter_id');

// IDs des scooters déjà réservés aujourd’hui
$scootersReserves = Calendar::whereDate('start', $today)
                            ->where('etat_reservation', 'confirmée')
                            ->pluck('scooter_id');

// Scooters non réservés
$nbrScootersDisponibles = Scooter::whereNotIn('id', $scootersReserves)->count();

        // Afficher le résultat
        // echo "Nombre total de scooters disponibles : " . $totalScootersDisponibles;

        // dd($nbrScootersDisponibles);

        $reservations = Calendar::with('client', 'scooter')
        ->orderBy('id', 'desc')
        ->limit(10) // pour éviter trop de lignes sur le dashboard
        ->get();
        
        return view('admin.dashboard', compact('reservations', 'totalConfirmée', 'totalEnCours', 'nbrScootersDisponibles'));
        }
            
}
