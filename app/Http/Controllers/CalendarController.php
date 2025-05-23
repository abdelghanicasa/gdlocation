<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Client;
use App\Models\PricePeriod;
use App\Models\Scooter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CalendarController extends Controller
{

    
    public function index()
    {
        
        $reservations = Calendar::orderBy('start', 'desc')->get();
        return view('admin.pages.calendar.list', compact('reservations'));
    }


    // Méthode pour afficher le calendrier
    public function showCalendar()
    {
        // Récupérer toutes les réservations
        $reservations = Calendar::all();  // Tu peux filtrer les réservations selon une condition si nécessaire
        $scooters = Scooter::orderBy('id', 'desc')->get();

        // Formater les réservations pour qu'elles soient compatibles avec FullCalendar
        $events = $reservations->map(function ($reservation) {
            return [
                'title' => $reservation->nom, //client->
                'start' => $reservation->start, // Combine la date et l'heure de début
                'end' => $reservation->end, // Combine la date et l'heure de fin
                'hdepart' => $reservation->start_time, // Combine la date et l'heure de fin
                'hretour' => $reservation->end_time, // Combine la date et l'heure de fin
                'color' => $reservation->color,
                'montant' => $reservation->montant,
                'scooter_id' => $reservation->scooter_id,
                // 'reference'=> $reservation->reference,
            ];
        });

        // dd($events);
        // Retourner la vue avec les événements
        return view('admin.pages.calendar.index', compact('events', 'scooters'));
    }

    public function updateEtatReservation(Request $request, $id)
    {
        $reservation = Calendar::findOrFail($id);
        $etat = $request->etat;

        if (!in_array($etat, ['confirmé', 'annulé'])) {
            return response()->json(['message' => 'État invalide.'], 400);
        }

        $reservation->etat_reservation = $etat;
        $reservation->save();

        return response()->json(['message' => "Réservation $etat avec succès."]);
    }


    public function show($id)
    {
        $reservation = Calendar::findOrFail($id);
        
        // Simuler des images de moto (à adapter selon votre structure réelle)
        $motoImages = [
            asset('fe/img/tmax-1.png'),
            asset('fe/img/tmax-2.png'),
            asset('fe/img/tmax-3.png'),
        ];
        
        return view('admin.pages.calendar.show', compact('reservation', 'motoImages'));
    }

    public function invoice(Calendar $reservation)
    {
        return view('admin.pages.calendar.invoice', compact('reservation'));
    }

    public function generateInvoice(Calendar $reservation)
    {
        // Calcul du montant (à adapter selon votre logique)
        $montantTotal = $reservation->nombre_jours * 100; // Ex: 100€ par jour
        
        $data = [
            'reservation' => $reservation,
            'montantTotal' => $montantTotal,
            'dateFacture' => now()->format('d/m/Y'),
            'company' => [
                'name' => config('app.name'),
                'address' => "123 Rue de la Moto",
                'phone' => "01 23 45 67 89",
                'email' => "contact@motolocation.com",
                'siret' => "123 456 789 00010"
            ]
        ];

        $pdf = PDF::loadView('admin.pages.calendar.invoice', $data);
        
        return $pdf->stream('facture-'.$reservation->reference.'.pdf');
        
        // Alternative pour téléchargement direct:
        // return $pdf->download('facture-'.$reservation->reference.'.pdf');
    }

    public function list(Request $request)
    {
        // $query = Calendar::query();
        $query = Calendar::with('client'); // 🔥 Inclure le client lié
    
        if ($request->has('date_filter')) {
            $query->whereDate('start', $request->date_filter);
        }
    
        if ($request->has('today')) {
            $query->whereDate('start', now()->format('Y-m-d'));
        }
    
        if ($request->has('period')) {
            switch ($request->period) {
                case 'week':
                    $query->whereBetween('start', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereBetween('start', [now()->startOfMonth(), now()->endOfMonth()]);
                    break;
            }
        }
    
        // 🎯 Nouveau filtre par état
        if ($request->filled('etat')) {
            $query->where('etat_reservation', $request->etat);
        }
    
        $reservations = $query->orderBy('start', 'desc')->paginate(15);
    
        return view('admin.pages.calendar.list', compact('reservations'));
    }
    

    // Exporter
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');

        $reservations = Calendar::all(); // Ou avec les filtres actuels

        if ($format === 'csv') {
            $filename = 'reservations_' . now()->format('Ymd_His') . '.csv';
            $headers = ['Content-Type' => 'text/csv'];
            $callback = function () use ($reservations) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['ID', 'Titre', 'Date début', 'Date fin', 'État']);
                foreach ($reservations as $r) {
                    fputcsv($handle, [
                        $r->id,
                        $r->title,
                        $r->start,
                        $r->end,
                        $r->etat_reservation,
                    ]);
                }
                fclose($handle);
            };
            return response()->stream($callback, 200, array_merge($headers, [
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ]));
        }

        if ($format === 'pdf') {
            $pdf = PDF::loadView('admin.pages.calendar.export_pdf', compact('reservations'));
            return $pdf->download('reservations_' . now()->format('Ymd_His') . '.pdf');
        }

        return redirect()->back()->with('error', 'Format non supporté');
    }


    public function create()
    {
        return view('calendar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'nombre_jours' => 'required|integer',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'tel' => 'required|string',
            'email' => 'required|email',
            'scooter_id' => 'required|exists:scooters,id'
        ]);
    
        // Combiner date et heures pour créer les datetime
        $startDateTime = $validated['date'] . ' ' . ($validated['start_time'] ?? '00:00:00');
        $endDateTime = $validated['date'] . ' ' . ($validated['end_time'] ?? '23:59:59');
    
        // Validation que l'heure de fin est après l'heure de début
        if (strtotime($endDateTime) <= strtotime($startDateTime)) {
            return response()->json([
                'message' => 'La date de retour doit être après la date de départ',
                'errors' => ['end_time' => ['La date de retour doit être après la date de départ']]
            ], 422);
        }
    
        $event = Calendar::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'nombre_jours' => $validated['nombre_jours'],
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'tel' => $validated['tel'],
            'email' => $validated['email'],
            'scooter_id' => $validated['scooter_id'],
            'start' => $startDateTime,
            'end' => $endDateTime
        ]);
    
        return response()->json($event);
    }

    public function edit($id)
    {
        $calendar = Calendar::findOrFail($id);
        $clients = Client::all();
        $scooters = Scooter::all();

        return view('admin.pages.calendar.edit', compact('calendar', 'clients', 'scooters'));
    }


    // Ajoute ici les méthodes edit, update, destroy, show si nécessaire

    // public function getEvents()
    // {
    //     $events = Calendar::all();
    //     // dd($events);
    //     return response()->json($events);
    // }
    public function getEvents()
    {
        $events = Calendar::all();
        $formatted = [];

        foreach ($events as $event) {
            // Événement de départ
            $formatted[] = [
                'id' => $event->id . '_start',
                // 'title' => 'D : ' . $event->prenom . ' ' . $event->nom,
                'title' => 'D : ' . $event->prenom . ' ' . $event->nom . ' à ' . $event->start_time,
                'start' => $event->start,
                'end' => $event->start,
                'scooter_id' => $event->scooter_id,
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
                'montant' => $event->montant,
                'nom' => $event->client->nom,
                'prenom' => $event->client->prenom,
                'email' => $event->client->email,
                'tel' => $event->client->tel,
                'color' => $event->color,
                // 'endDate' => $event->end,
            ];

            // Événement de retour
            $formatted[] = [
                'id' => $event->id . '_end',
                'title' => 'R : ' . $event->prenom . ' ' . $event->nom . ' à ' . $event->end_time,
                'start' => $event->end,
                'end' => $event->end,
                'scooter_id' => $event->scooter_id,
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
                'montant' => $event->montant,
                'nom' => $event->client->nom,
                'prenom' => $event->client->prenom,
                'email' => $event->client->email,
                'tel' => $event->client->tel, 
                'custom_end' => $event->end,
                'color' => $event->color,
                // 'endDate' => $event->end,           
            ];
        }

        return response()->json($formatted);
    }


    // public function cstore(Request $request)
    // {
    //     // dd($request->all());
    //     $validated = $request->validate([
    //         'nom' => 'required|string|max:255',
    //         'prenom' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'tel' => 'required|string|max:20',
    //         'start' => 'required|date',
    //         'end' => 'required|date',
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i',
    //         'nombre_jours' => 'required|integer|min:1',
    //         'scooter_id' => 'required|exists:scooters,id',
    //         'color' => 'nullable',
    //         'reference' => 'nullable',
    //     ]);
    
    //     // Combiner date et heures pour créer les datetime
    //     $startDateTime = $validated['start'];
    //     $endDateTime = $validated['end'];
    
    //     $event = Calendar::create([
    //         'nom' => $validated['nom'],
    //         'prenom' => $validated['prenom'],
    //         'email' => $validated['email'],
    //         'tel' => $validated['tel'],
    //         'start' => $startDateTime,
    //         'end' => $endDateTime,
    //         'start_time' => $validated['start_time'],
    //         'end_time' => $validated['end_time'],
    //         'nombre_jours' => $validated['nombre_jours'],
    //         'scooter_id' => $validated['scooter_id'],
    //         'title' => $validated['nom'] . ' ' . $validated['prenom'],
    //         'color' => $validated['color'],
    //         'reference' => strtoupper(uniqid('gl-')), // Generate a unique reference,
    //     ]);
    
    //     return response()->json($event);
    // }

    // public function cstore(Request $request)
    // {


    //     $validated = $request->validate([
    //         'nom' => 'required|string|max:255',
    //         'prenom' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'tel' => 'required|string|max:20',
    //         'start' => 'required|date',
    //         'end' => 'required|date',
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i',
    //         'nombre_jours' => 'required|integer|min:1',
    //         'scooter_id' => 'required|exists:scooters,id',
    //         'color' => 'nullable',
    //         'reference' => 'nullable',
    //     ]);
    
    //     // Vérifie si le client existe déjà
    //     $client = Client::where('email', $validated['email'])
    //                     ->first();
    
    //     // S'il n'existe pas, on le crée
    //     if (!$client) {
    //         $client = Client::create([
    //             'nom' => $validated['nom'],
    //             'prenom' => $validated['prenom'],
    //             'email' => $validated['email'],
    //             'tel' => $validated['tel'],
    //             // Ajouter ici les autres champs si ta table clients en contient plus
    //         ]);
    //     }
    
    //     // dd($client);

    //     // Crée la réservation en gardant une copie des infos
    //     $event = Calendar::create([
    //         'nom' => $validated['nom'],
    //         'prenom' => $validated['prenom'],
    //         'email' => $validated['email'],
    //         'tel' => $validated['tel'],
    //         'start' => $validated['start'],
    //         'end' => $validated['end'],
    //         'start_time' => $validated['start_time'],
    //         'end_time' => $validated['end_time'],
    //         'nombre_jours' => $validated['nombre_jours'],
    //         'scooter_id' => $validated['scooter_id'],
    //         'title' => $validated['nom'] . ' ' . $validated['prenom'],
    //         'color' => $validated['color'],
    //         'reference' => strtoupper(uniqid('gl-')),
    //         'client_id' => $client->id, // Associe le client
    //     ]);
    
    //     return response()->json($event);
    // }
    
    // public function cstore(Request $request)
    // {
    //     $validated = $request->validate([
    //         'nom' => 'required|string|max:255',
    //         'prenom' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'tel' => 'required|string|max:20',
    //         'start' => 'required|date',
    //         'end' => 'required|date',
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i',
    //         'nombre_jours' => 'required|integer|min:1',
    //         'scooter_id' => 'required|exists:scooters,id',
    //         'color' => 'nullable',
    //         'reference' => 'nullable',
    //     ]);
    
    //     // 🛵 Étape 1 : Vérifier la disponibilité du scooter
    //     $scooter = Scooter::find($validated['scooter_id']);
    
    //     if ($scooter->disponible <= 0) {
    //         return response()->json([
    //             'message' => 'Aucun scooter disponible pour cette réservation.',
    //         ], 400);
    //     }
    
    //     // 👤 Étape 2 : Vérifier si le client existe déjà
    //     $client = Client::where('email', $validated['email'])
    //                     ->orWhere('tel', $validated['tel'])
    //                     ->first();
    
    //     if (!$client) {
    //         $client = Client::create([
    //             'nom' => $validated['nom'],
    //             'prenom' => $validated['prenom'],
    //             'email' => $validated['email'],
    //             'tel' => $validated['tel'],
    //             // ajouter ici les autres champs si besoin
    //         ]);
    //     }
    
    //     // 📅 Étape 3 : Créer la réservation
    //     $event = Calendar::create([
    //         'nom' => $validated['nom'],
    //         'prenom' => $validated['prenom'],
    //         'email' => $validated['email'],
    //         'tel' => $validated['tel'],
    //         'start' => $validated['start'],
    //         'end' => $validated['end'],
    //         'start_time' => $validated['start_time'],
    //         'end_time' => $validated['end_time'],
    //         'nombre_jours' => $validated['nombre_jours'],
    //         'scooter_id' => $validated['scooter_id'],
    //         'title' => $validated['nom'] . ' ' . $validated['prenom'],
    //         'color' => $validated['color'],
    //         'reference' => strtoupper(uniqid('gl-')),
    //         'client_id' => $client->id,
    //     ]);
    
    //     // 🔄 Étape 4 : Décrémenter la disponibilité du scooter
    //     $scooter->disponible -= 1;
    //     $scooter->save();
    
    //     return response()->json($event);
    // }
    
        public function cstore(Request $request)
        {
            // Validation des données
            // dd($request->montant);
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'tel' => 'required|string|max:20',
                'start' => 'required|date',
                'end' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i',
                'nombre_jours' => 'required|integer|min:1',
                'scooter_id' => 'required|exists:scooters,id',
                'color' => 'nullable',
                'reference' => 'nullable',
                'montant'=> 'required',
            ]);
        
            // 🛵 Étape 1 : Vérifier la disponibilité du scooter
            $scooter = Scooter::find($validated['scooter_id']);
        
            // Si le scooter n'a plus de disponibilité
            if ($scooter->disponible <= 0) {
                return response()->json([
                    'message' => 'Aucun scooter disponible pour cette réservation.',
                ], 400);
            }
        
            // 👤 Étape 2 : Vérifier si le client existe déjà
            $client = Client::where('email', $validated['email'])
                            ->orWhere('tel', $validated['tel'])
                            ->first();
        
            if (!$client) {
                // Créer un nouveau client s'il n'existe pas
                $client = Client::create([
                    'nom' => $validated['nom'],
                    'prenom' => $validated['prenom'],
                    'email' => $validated['email'],
                    'tel' => $validated['tel'],
                    // Ajouter ici d'autres champs si besoin
                ]);
            }
        
            // 📅 Étape 3 : Créer la réservation
            $event = Calendar::create([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'email' => $validated['email'],
                'tel' => $validated['tel'],
                'start' => $validated['start'],
                'end' => $validated['end'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'nombre_jours' => $validated['nombre_jours'],
                'scooter_id' => $validated['scooter_id'],
                'title' => $validated['nom'] . ' ' . $validated['prenom'],
                'montant' => $validated['montant'],
                'color' => $validated['scooter_id'] == 2 ? '#5a9936' : '#237ea6',
                'reference' => strtoupper(uniqid('gl-')), // Générer une référence unique
                'client_id' => $client->id, // Associe le client
            ]);
        
            // 🔄 Étape 4 : Décrémenter la disponibilité du scooter
            $scooter->disponible -= 1;
        
            // Si aucun scooter n'est disponible, on marque le scooter comme non disponible
            if ($scooter->disponible <= 0) {
                $scooter->disponible = 0;  // Met la disponibilité à zéro
                $scooter->statut = 'non disponible'; // Change le statut du scooter à "non disponible"
            }
        
            // Sauvegarder les modifications du scooter
            $scooter->save();
        
            // Retourner la réservation créée
            return response()->json($event);
        }
    
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $event = Calendar::findOrFail($id);
    
        // Validation des champs reçus dans la requête
        $request->validate([
            'nom' => 'nullable|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'tel' => 'nullable|string|max:20',
            'start' => 'required',
            'end' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'nombre_jours' => 'required|integer|min:1',
            'scooter_id' => 'required|exists:scooters,id',
            'color' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'montant' => 'required',
            'age_conducteur' => 'required',
        ]);
    
        // Mise à jour de l'événement avec les données validées
        $event->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'tel' => $request->tel,
            // 'title' => $request->title, // Assuming you have a 'title' field in your Calendar model
            'start' => $request->start,
            'end' => $request->end,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'nombre_jours' => $request->nombre_jours,
            'scooter_id' => $request->scooter_id,
            // 'color' => $request->color ?? $event->color, 
            'color' => $request['scooter_id'] == 2 ? '#5a9936' : '#237ea6',
            'reference' => $request->reference ?? $event->reference, 
            'description' => $request->description ?? $event->description, 
            'montant' => $request->montant ?? $event->montant, 
            'age_conducteur' => $request->age_conducteur, 
        ]);
    
        // dd($event);
        // Retourner une réponse JSON avec l'événement mis à jour
        
        return redirect()->route('admin.calendar.list')->with('success', 'La réservation a été mise à jour avec succès.');

        // return response()->json($event);
    }

    public function destroy($id)
    {
        $event = Calendar::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Réservation supprimée']);
    }

    public function destroyList($id)
    {
        $event = Calendar::findOrFail($id);
        $event->delete();

        // return response()->json(['message' => 'Réservation supprimée']);
        return redirect()->route('admin.calendar.list')->with('success', 'Réservation supprimé avec succès');
    }   

    public function calculatePrice(Request $request)
    {
    $scooterId = $request->input('scooter_id');
    $fromDate = Carbon::parse($request->input('from_date'));
    $toDate = Carbon::parse($request->input('to_date'));
    $daysCount = $fromDate->diffInDays($toDate) + 1;

    // 1. Récupérer la période de prix
    $period = PricePeriod::where('scooter_id', $scooterId)
        ->whereDate('start_date', '<=', $fromDate)
        ->whereDate('end_date', '>=', $toDate)
        ->first();

    if ($period) {
        // Il y a une période
        $ranges = $period->price_ranges;

        if ($ranges && is_array($ranges)) {
            foreach ($ranges as $range) {
                if (
                    $daysCount >= (int)$range['min_days'] &&
                    $daysCount <= (int)$range['max_days']
                ) {
                    return response()->json([
                        'price' => $range['price'],
                        'days' => $daysCount,
                        'total' => $range['price'] * 1,
                    ]);
                }
            }
        }

        // Si pas de range valide, utiliser le prix de base de la période
        return response()->json([
            'price' => $period->price,
            'days' => $daysCount,
            'total' => $period->price * $daysCount,
        ]);
    }

    // 2. Aucune période trouvée → on prend prix_journalier depuis la table scooters
    $scooter = Scooter::find($scooterId);
    if ($scooter && $scooter->prix_journalier) {
        return response()->json([
            'price' => $scooter->prix_journalier,
            'days' => $daysCount,
            'total' => $scooter->prix_journalier * $daysCount,
        ]);
    }

    // 3. Aucun prix trouvé du tout
    return response()->json(['error' => 'No pricing available'], 404);
    }


public function showImportForm()
{
    return view('admin.pages.calendar.upload');
}

public function cstoreImport(Request $request)
{
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt',
    ]);

    // Lire le fichier temporairement sans le déplacer
    $file = $request->file('csv_file');
    $rows = array_map('str_getcsv', file($file));

    $headers = [
        'nom', 'prenom', 'start', 'end', 'start_time', 'end_time',
        'scooter_id', 'tel', 'email', 'montant'
    ];

    // Vérifier les colonnes obligatoires
    $requiredHeaders = $headers;
    $missing = array_diff($requiredHeaders, $headers);

    if (count($missing)) {
        return back()->withErrors(['csv_file' => 'Colonnes manquantes : ' . implode(', ', $missing)]);
    }

    // Fonction pour parser les dates avec plusieurs formats
    $parseDate = function($dateStr) {
        $formats = ['d-m-Y', 'd/m/Y', 'd-m-y', 'd/m/y', 'Y-m-d'];
        foreach ($formats as $format) {
            try {
                return \Carbon\Carbon::createFromFormat($format, $dateStr)->format('Y-m-d');
            } catch (\Exception $e) {
                // Essayer le format suivant
            }
        }
        // Dernier recours: parse classique
        try {
            return \Carbon\Carbon::parse(str_replace('/', '-', $dateStr))->format('Y-m-d');
        } catch (\Exception $e) {
            throw new \Exception("Format de date invalide: '$dateStr'");
        }
    };

    foreach ($rows as $index => $row) {
        // Sauter les lignes avec un nombre incorrect de colonnes
        if (count($row) < count($headers)) {
            return back()->withErrors(['csv_file' => "Erreur à la ligne " . ($index + 1) . " : colonnes manquantes ou mal formattées"]);
        }

        $data = array_combine($headers, array_map('trim', $row));

        try {
            $start = $parseDate($data['start']);
            $end = $parseDate($data['end']);

            $client = Client::firstOrCreate(
                [
                    'nom' => $data['nom'] ?? '',
                    'prenom' => $data['prenom'] ?? '',
                ],
                [
                    'tel' => $data['tel'] ?? '',
                    'email' => $data['email'] ?? '',
                ]
            );

            Calendar::create([
                'client_id' => $client->id,
                'start' => $start,
                'end' => $end,
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'scooter_id' => $data['scooter_id'],
                'color' => $data['scooter_id'] == 2 ? '#5a9936' : '#237ea6',
                'montant' => $data['montant'],
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'tel' => $data['tel'],
            ]);
        } catch (\Exception $e) {
            // Log l'erreur pour diagnostic plus facile
            \Log::error("Erreur import CSV ligne " . ($index + 1) . ": " . $e->getMessage(), ['row' => $data]);
            return back()->withErrors(['csv_file' => "Erreur à la ligne " . ($index + 1) . ": " . $e->getMessage()]);
        }
    }

    return back()->with('success', 'Importation réussie !');
}



}
