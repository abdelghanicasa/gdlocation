<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Calendar;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with('calendar')->paginate(10);
        
        // Debug
        logger($paiements->toArray());
        // dd($paiements);
        
        return view('admin.pages.paiements.index', compact('paiements'));
    }
    

    // public function genererFacture(Paiement $paiement)
    // {
    //     $pdf = PDF::loadView('pdf.facture', [
    //         'paiement' => $paiement,
    //         'societe' => [
    //             'nom' => config('app.name'),
    //             'adresse' => "123 Rue des Entreprises",
    //             'siret' => "123 456 789 00010"
    //         ]
    //     ]);

    //     // Envoi par email
    //     Mail::to($paiement->reservation->email)
    //         ->send(new FactureMail($paiement, $pdf));

    //     return $pdf->stream("facture-{$paiement->reference}.pdf");
    // }

    // public function exporter()
    // {
    //     return Excel::download(new PaiementsExport, 'paiements-'.now()->format('Y-m-d').'.csv');
    // }
}

