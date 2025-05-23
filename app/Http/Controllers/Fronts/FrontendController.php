<?php

namespace App\Http\Controllers\Fronts;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use App\Models\Scooter;
use App\Models\Post; // Import the Post model
use App\Models\PostBlock; // Import the PostBlock model
use App\Models\Client;
use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\SogecommerceService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    protected $sogecommerce;

    public function __construct(SogecommerceService $sogecommerce)
    {
        $this->sogecommerce = $sogecommerce;
    }

    public function accueil()
    {
        // Debug date actuelle
        // dd(now()->toDateString()); // Doit afficher "2025-04-14" pour votre test
        
        $tmaxScooters = Scooter::with('pricePeriods')
            ->where('statut', 'disponible')
            // ->where('modele', 'tmax')
            ->get();
            // ->each(function($scooter) {
            //     $scooter->current_price = $scooter->getPriceForDate(now());
                // Debug pour chaque scooter
                // dump([
                //     'scooter' => $scooter->id,
                //     'modele' => $scooter->modele,
                //     'prix_normal' => $scooter->prix_journalier,
                //     'prix_calcule' => $scooter->current_price,
                //     'periodes' => $scooter->pricePeriods->toArray()
                // ]);
            
        $apriliaScooters = Scooter::with('pricePeriods')
            ->where('statut', 'disponible')
            ->where('modele', 'aprilia')
            ->get();
            
           

        // Fetch posts for the homepage
        $posts = Post::with('blocks')->where('page_id', 1)->get(); // Assuming page_id = 1 is for "Accueil"

        return view('frontend.pages.accueil', compact('apriliaScooters', 'tmaxScooters', 'posts'));
    }

    public function scooter()
    {
        $tmaxScooters = Scooter::where('statut', 'disponible')
            ->where('modele', 'tmax')
            ->get();
            // ->each(function($scooter) {
            //     $scooter->current_price = $scooter->getPriceForDate(now());
            // });
        $apriliaScooters = Scooter::where('statut', 'disponible')
            ->where('modele', 'aprilia')
            ->get();
            // ->each(function($scooter) {
            //     $scooter->current_price = $scooter->getPriceForDate(now());
            // });    

        // Fetch blocks for the scooter page
        $posts = Post::with('blocks')->where('page_id', 2)->get(); // Assuming page_id = 1 is for "Accueil"

        return view('frontend.pages.scooter', compact('apriliaScooters', 'tmaxScooters', 'posts'));
    }
    
    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function condition()
    {
        return view('frontend.pages.conditions');
    } 
       public function terms()
    {
        return view('frontend.pages.terms');
    } 
    
    public function sendContactForm(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',      
            'email' => 'required|email',
            'message' => 'required|string',
            'sujet' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
        ]);
    
        Mail::to('el.abdelghani@gmail.com')->send(new ContactFormMail($data));
    
        return back()->with('success', 'Votre message a été envoyé avec succès !');
    }

    
    public function reservation(Request $request)
    {
        // dd($request->all());
        try {
            // Convertir les dates avant validation
            $request->merge([
                'cs_datetimes_start' => $this->convertToIsoFormat($request->cs_datetimes_start),
                'cs_datetimes_end' => $this->convertToIsoFormat($request->cs_datetimes_end)
            ]);
    
            // Validation des données
            $validatedData = $request->validate([
                'cs_datetimes_start' => 'required|date',
                'cs_datetimes_end' => 'required|date|after:cs_datetimes_start',
                'age_conducteur' => 'required|integer|min:18'
            ], [
                'age_conducteur.min' => 'Le conducteur doit avoir au moins 18 ans',
                'cs_datetimes_end.after' => 'La date de fin doit être après la date de début'
            ]);

            
            $startDate = Carbon::parse($validatedData['cs_datetimes_start']);
            $endDate = Carbon::parse($validatedData['cs_datetimes_end']);
            $driverAge = $validatedData['age_conducteur'];

            // CORRECTION: Calcul de la durée en jours calendaires inclusifs
            $duration = $startDate->diffInDays($endDate);  //  + 1     

            // dd($endDate);
            $scooters = Scooter::with('pricePeriods')->get()
                ->each(function ($scooter) use ($startDate, $endDate) {
                    $scooter->current_price = $scooter->getAveragePriceForDisplay($startDate, $endDate);
                });
    
            return view('frontend.pages.reservation', [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'driverAge' => $driverAge,
                'scooterss' => $scooters,
                'oldInput' => $request->all(),
                'duration' => $duration, // Ajout de la durée
            ]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('swal_error', 'Veuillez corriger les erreurs de formulaire.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('swal_error', 'Une erreur inattendue est survenue: '.$e->getMessage());
        }
    
        return back()->with('error', 'Une erreur inattendue est survenue lors de la réservation.');
    }
    
    
    // Fonction pour obtenir le prix en fonction de la durée
    private function getPriceForDuration($scooter, $duration)
    {
        foreach (json_decode($scooter->price_periods, true) as $range) {
            if ($duration >= $range['min_days'] && $duration <= $range['max_days']) {
                return $range['price'];
            }
        }
    
        // Si aucune plage ne correspond, retourner le prix standard
        return $scooter->prix_journalier;
    }
    

    public function createPaymentOrder(array $orderData)
    {
        $endpoint = '/api-payment/V4/Charge/CreatePaymentOrder';
        $url = config('sogecommerce.api_url') . $endpoint;

        $payload = [
            'amount' => $orderData['amount'] * 100, // Convertir en centimes
            'currency' => 'EUR',
            'orderId' => $orderData['orderId'],
            'channelOptions' => [
                'channelType' => 'URL'
            ],
            'configuration' => [
                'returnUrl' => route('payment.response'),
                'notificationUrl' => route('payment.ipn')
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode(
                config('sogecommerce.merchant_id') . ':' . config('sogecommerce.test_password')
            )
        ])->post($url, $payload);

        return $response->json();
    }

    // public function createReservation(Request $request)
    // {
       
    //     try {
    //         // Validate the request data
    //         $validatedData = $request->validate([
    //             'nom' => 'nullable|string|max:255',
    //             'prenom' => 'nullable|string|max:255',
    //             'email' => 'nullable|email|max:255',
    //             'tel' => 'nullable|string|max:20',
    //             'adresse' => 'nullable|string|max:255',
    //             'ville' => 'nullable|string|max:255',
    //             'code_postal' => 'nullable|string|max:10',
    //             'age_conducteur' => 'required|integer|min:18',
    //             'start' => 'required|date_format:d/m/Y',
    //             'end' => 'required|date_format:d/m/Y|after:start',
    //             'start_time' => 'required|date_format:H\Hi',
    //             'end_time' => 'required|date_format:H\Hi',
    //             'scooter_id' => 'required|exists:scooters,id',
    //             'nombre_jours' => 'required|integer|min:1',
    //             'montant' => 'required|numeric|min:0.01',
    //         ]);
    //         // dd($validatedData['montant']);
    //         // Convert dates and times to the correct format
    //         $startDateTime = Carbon::createFromFormat('d/m/Y H\Hi', $validatedData['start'] . ' ' . $validatedData['start_time'])->format('Y-m-d H:i:s');
    //         $endDateTime = Carbon::createFromFormat('d/m/Y H\Hi', $validatedData['end'] . ' ' . $validatedData['end_time'])->format('Y-m-d H:i:s');
    //         $startDate = Carbon::createFromFormat('d/m/Y', $validatedData['start'])->format('Y-m-d');
    //         $endDate = Carbon::createFromFormat('d/m/Y', $validatedData['end'])->format('Y-m-d');

    //         // Create or find the client
    //         $client = Client::firstOrCreate(
    //             ['email' => $validatedData['email']],
    //             [
    //                 'nom' => $validatedData['nom'],
    //                 'prenom' => $validatedData['prenom'],
    //                 'tel' => $validatedData['tel'],
    //                 'adresse' => $validatedData['adresse'],
    //                 'ville' => $validatedData['ville'],
    //                 'code_postal' => $validatedData['code_postal'],
    //             ]
    //         );

    //         // Create the reservation in the calendars table
    //         $calendar = Calendar::create([
    //             'title' => 'Réservation de ' . $validatedData['prenom'] . ' ' . $validatedData['nom'],
    //             'description' => 'Réservation pour le scooter ID: ' . $validatedData['scooter_id'],
    //             'age_conducteur' => $validatedData['age_conducteur'],
    //             'start' => $startDateTime, // Utilisez $startDateTime au lieu de $startDate
    //             'end' => $endDateTime,     // Utilisez $endDateTime au lieu de $endDate
    //             'start_time' => $startDateTime,
    //             'end_time' => $endDateTime,
    //             'location' => $validatedData['ville'],
    //             'montant' => $validatedData['montant'],
    //             'etat_paiement' => 'en attente', // Default payment status
    //             'etat_reservation' => 'confirmée', // Default reservation status
    //             'nombre_jours' => $validatedData['nombre_jours'],
    //             'reference' => strtoupper(uniqid('RES-')), // Generate a unique reference
    //             'client_id' => $client->id,
    //             'scooter_id' => $validatedData['scooter_id'],
    //             'nom' => $validatedData['nom'],
    //             'prenom' => $validatedData['prenom'],
    //             'tel' => $validatedData['tel'],
    //             'adresse' => $validatedData['adresse'],
    //             'ville' => $validatedData['ville'],
    //             'code_postal' => $validatedData['code_postal'],
    //             'email' => $validatedData['email'],

    //         ]);

    //         $paymentData = [
    //             'amount' => $validatedData['montant'],
    //             'orderId' => $calendar->reference,
    //             'email' => $validatedData['email']
    //         ];
        
    //         // Appel au service Sogecommerce
    //         // $paymentResponse = $this->sogecommerce->createPaymentOrder($paymentData);

    //         // if (isset($paymentResponse['answer']['orderStatus'])) {
    //         //     // Redirection vers le formulaire de paiement
    //         //     return redirect()->away($paymentResponse['answer']['paymentUrl']);
    //         // }

    //         return redirect()->route('paiement.sogecommerce', ['id' => $calendar->id]);

    //         // En cas d'échec
    //         // return back()->with('error', 'Erreur lors de la création du paiement !!');

    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Erreur: '.$e->getMessage());
    //     }
    // }
    
    // public function createReservation(Request $request)
    // {
    //     try {
    //         // ✅ Étape 1 : Validate the request data
    //         $validatedData = $request->validate([
    //             'nom' => 'nullable|string|max:255',
    //             'prenom' => 'nullable|string|max:255',
    //             'email' => 'nullable|email|max:255',
    //             'tel' => 'nullable|string|max:20',
    //             'adresse' => 'nullable|string|max:255',
    //             'ville' => 'nullable|string|max:255',
    //             'code_postal' => 'nullable|string|max:10',
    //             'age_conducteur' => 'required|integer|min:18',
    //             'start' => 'required|date_format:d/m/Y',
    //             'end' => 'required|date_format:d/m/Y|after:start',
    //             'start_time' => 'required|date_format:H\Hi',
    //             'end_time' => 'required|date_format:H\Hi',
    //             'scooter_id' => 'required|exists:scooters,id',
    //             'nombre_jours' => 'required|integer|min:1',
    //             'montant' => 'required|numeric|min:0.01',
    //         ]);

    //         // ✅ Étape 2 : Vérifie la disponibilité avant toute action
    //         $scooter = Scooter::find($validatedData['scooter_id']);
    //         if ($scooter->disponible <= 0) {
    //             return back()->with('error', 'Ce scooter n\'est plus disponible.');
    //         }

    //         // ✅ Étape 3 : Convert dates
    //         $startDateTime = Carbon::createFromFormat('d/m/Y H\Hi', $validatedData['start'] . ' ' . $validatedData['start_time'])->format('Y-m-d H:i:s');
    //         $endDateTime = Carbon::createFromFormat('d/m/Y H\Hi', $validatedData['end'] . ' ' . $validatedData['end_time'])->format('Y-m-d H:i:s');

    //         // ✅ Étape 4 : Crée ou récupère le client
    //         $client = Client::firstOrCreate(
    //             ['email' => $validatedData['email']],
    //             [
    //                 'nom' => $validatedData['nom'],
    //                 'prenom' => $validatedData['prenom'],
    //                 'tel' => $validatedData['tel'],
    //                 'adresse' => $validatedData['adresse'],
    //                 'ville' => $validatedData['ville'],
    //                 'code_postal' => $validatedData['code_postal'],
    //             ]
    //         );

    //         // ✅ Étape 5 : Crée la réservation
    //         $calendar = Calendar::create([
    //             'title' => 'Réservation de ' . $validatedData['prenom'] . ' ' . $validatedData['nom'],
    //             'description' => 'Réservation pour le scooter ID: ' . $validatedData['scooter_id'],
    //             'age_conducteur' => $validatedData['age_conducteur'],
    //             'start' => $startDateTime,
    //             'end' => $endDateTime,
    //             'start_time' => $startDateTime,
    //             'end_time' => $endDateTime,
    //             'location' => $validatedData['ville'],
    //             'montant' => $validatedData['montant'],
    //             'etat_paiement' => 'en attente',
    //             'etat_reservation' => 'confirmée',
    //             'nombre_jours' => $validatedData['nombre_jours'],
    //             'reference' => strtoupper(uniqid('RES-')),
    //             'client_id' => $client->id,
    //             'scooter_id' => $validatedData['scooter_id'],
    //             'nom' => $validatedData['nom'],
    //             'prenom' => $validatedData['prenom'],
    //             'tel' => $validatedData['tel'],
    //             'adresse' => $validatedData['adresse'],
    //             'ville' => $validatedData['ville'],
    //             'code_postal' => $validatedData['code_postal'],
    //             'email' => $validatedData['email'],
    //         ]);

    //         // ✅ Étape 6 : Décrémente le nombre de scooters disponibles
    //         $scooter->disponible -= 1;
    //         $scooter->save();

    //         // ✅ Étape 7 : Redirection vers le paiement
    //         return redirect()->route('paiement.sogecommerce', ['id' => $calendar->id]);

    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Erreur: '.$e->getMessage());
    //     }
    // }

    public function createReservation(Request $request)
    {
        // dd($request->all());
        try {
            // ✅ Étape 1 : Validation des données de la requête
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'tel' => 'required|string|max:20',
                'adresse' => 'nullable|string|max:255',
                'ville' => 'nullable|string|max:255',
                'code_postal' => 'nullable|string|max:10',
                'age_conducteur' => 'required|integer|min:18',
                'start' => 'required|date_format:d/m/Y',
                'end' => 'required|date_format:d/m/Y|after:start',
                'start_time' => 'required|date_format:H\Hi',
                'end_time' => 'required|date_format:H\Hi',
                'scooter_id' => 'required|exists:scooters,id',
                'nombre_jours' => 'required|integer|min:1',
                'montant' => 'required|numeric|min:0.01',
            ]);

            // ✅ Étape 2 : Vérifie la disponibilité avant toute action
            $scooter = Scooter::find($validatedData['scooter_id']);
            
            // Vérifie si le scooter est disponible
            if ($scooter->disponible <= 0) {
                return back()->with('error', 'Ce scooter n\'est plus disponible.');
            }

            // ✅ Étape 3 : Convertir les dates
            $startDateTime = Carbon::createFromFormat('d/m/Y H\Hi', $validatedData['start'] . ' ' . $validatedData['start_time'])->format('Y-m-d H:i:s');
            $endDateTime = Carbon::createFromFormat('d/m/Y H\Hi', $validatedData['end'] . ' ' . $validatedData['end_time'])->format('Y-m-d H:i:s');

            // ✅ Étape 4 : Crée ou récupère le client
            $client = Client::firstOrCreate(
                ['email' => $validatedData['email']],
                [
                    'nom' => $validatedData['nom'],
                    'prenom' => $validatedData['prenom'],
                    'tel' => $validatedData['tel'],
                    'adresse' => $validatedData['adresse'],
                    'ville' => $validatedData['ville'],
                    'code_postal' => $validatedData['code_postal'],
                ]
            );

            // ✅ Étape 5 : Créer la réservation
            $calendar = Calendar::create([
                'title' => 'Réservation de ' . $validatedData['prenom'] . ' ' . $validatedData['nom'],
                'description' => 'Réservation pour le scooter ID: ' . $validatedData['scooter_id'],
                'age_conducteur' => $validatedData['age_conducteur'],
                'start' => $startDateTime,
                'end' => $endDateTime,
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,
                'location' => $validatedData['ville'],
                'montant' => $validatedData['montant'],
                'etat_paiement' => 'en attente',  // Par défaut, statut de paiement
                'etat_reservation' => 'en attente',  // Par défaut, statut de réservation
                'nombre_jours' => $validatedData['nombre_jours'],
                'reference' => strtoupper(uniqid('RES-')),  // Référence unique pour la réservation
                'client_id' => $client->id,  // ID du client
                'scooter_id' => $validatedData['scooter_id'],  // ID du scooter réservé
                'nom' => $validatedData['nom'],
                'prenom' => $validatedData['prenom'],
                'tel' => $validatedData['tel'],
                'adresse' => $validatedData['adresse'],
                'ville' => $validatedData['ville'],
                'code_postal' => $validatedData['code_postal'],
                'email' => $validatedData['email'],
                'color' => $validatedData['scooter_id'] == 2 ? '#5a9936' : '#237ea6',
            ]);

            // ✅ Étape 6 : Décrémente le nombre de scooters disponibles
            $scooter->disponible -= 1;
            
            // Si la disponibilité du scooter atteint zéro, on marque ce scooter comme non disponible
            if ($scooter->disponible <= 0) {
                $scooter->statut = 'non disponible';  // Met le statut à "non disponible"
            }

            $scooter->save();  // Sauvegarde les changements

                    // ✅ Étape 7 : Enregistre la référence dans la session (expire selon config/session.php)
            session(['reservation_reference' => $calendar->reference]);

            // ✅ Étape 7 : Redirection vers le paiement
            return redirect()->route('paiement.sogecommerce', ['id' => $calendar->id]);

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur: '.$e->getMessage());
        }
    }

    
    public function handlePaymentResponse(Request $request)
    {
        // Récupérer l'ID de commande
        $orderId = $request->input('orderId');
        
        // Récupérer la réservation
        $reservation = Calendar::where('reference', $orderId)->firstOrFail();
        
        // Vérifier le statut du paiement
        if ($request->input('response_code') === '00') {
            // Paiement réussi
            $reservation->update(['etat_paiement' => 'payé']);
            return view('frontend.pages.payment.success');
        } else {
            // Paiement échoué
            $reservation->update(['etat_paiement' => 'échoué']);
            return view('frontend.pages.payment.error', [
                'error' => $request->input('response_error') ?? 'Paiement refusé'
            ]);
        }
    }

    public function handlePaymentNotification(Request $request)
    {
        // Valider la notification
        if (!$this->sogecommerce->verifyIpnSignature($request->all())) {
            Log::error('Signature IPN invalide', $request->all());
            abort(403);
        }

        // Traiter la notification
        $orderId = $request->input('orderId');
        $status = $request->input('response_code');
        
        $reservation = Calendar::where('reference', $orderId)->firstOrFail();
        
        if ($status === '00') {
            $reservation->update(['etat_paiement' => 'payé']);
        } else {
            $reservation->update(['etat_paiement' => 'échoué']);
        }

        return response()->json(['status' => 'ok']);
    }

    private function generateSeal($config, $data, $calendar)
    {
        $stringToSign = implode('', [
            $config['merchantId'],
            $data['montant'] * 100,
            '978', // EUR
            $calendar->reference
        ]);

        return hash_hmac('sha256', $stringToSign, $config['secretKey']);
    }

    private function getValidationMessage($exception)
    {
        $errors = $exception->validator->errors()->all();
        return implode('<br>', $errors);
    }

    private function convertToIsoFormat($dateString)
    {
        if (empty($dateString)) return null;
        
        try {
            // Essayer de parser le format "d/m/Y H:i"
            return Carbon::createFromFormat('d/m/Y H:i', urldecode($dateString))->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            // Si échec, retourner la valeur originale
            return $dateString;
        }
    }

    public function societe()
    {
        // Fetch the company information from the database
        $companyInfo = Post::with('blocks')->where('page_id', 3)->get(); // Assuming page_id = 3 is for "Societe"

        return view('frontend.pages.societe', compact('companyInfo'));
    }

    /*getPriceForDays */
    // public function getPriceForDays(Request $request)
    // {
    //     dd($request->all());
    //     $scooter = Scooter::with('pricePeriods')->findOrFail($request->scooter_id);
    //     $days = (int) $request->days;

    //     $date = now()->format('Y-m-d');

    //     $period = $scooter->pricePeriods
    //         ->where('start_date', '<=', $date)
    //         ->where('end_date', '>=', $date)
    //         ->first();

    //     if (!$period) {
    //         return response()->json(['price' => $scooter->default_price ?? 100]); // Fallback
    //     }

    //     $ranges = is_string($period->price_ranges)
    //         ? json_decode($period->price_ranges, true)
    //         : $period->price_ranges;

    //     if (!empty($ranges)) {
    //         foreach ($ranges as $range) {
    //             if ((int)$range['min_days'] <= $days && $days <= (int)$range['max_days']) {
    //                 return response()->json(['price' => (float)$range['price']]);
    //             }
    //         }
    //     }

    //     return response()->json(['price' => (float)($period->price ?? $scooter->default_price ?? 100)]);
    // }

    // CPT
    /**
     * /
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getPriceForDays(Request $request)
    {
        $scooter = Scooter::with('pricePeriods')->findOrFail($request->scooter_id);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $totalDays = $startDate->diffInDays($endDate); // + 1
        $totalPrice = 0;
        $log = [];

        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $period = $scooter->pricePeriods->first(function ($p) use ($currentDate) {
                return Carbon::parse($p->start_date)->lte($currentDate) &&
                    Carbon::parse($p->end_date)->gte($currentDate);
            });

            if (!$period) {
                $totalPrice += $scooter->default_price ?? 100;
                $log[] = [
                    'date' => $currentDate->toDateString(),
                    'price' => $scooter->default_price ?? 100,
                    'source' => 'default',
                ];
                $currentDate->addDay();
                continue;
            }

            $ranges = is_string($period->price_ranges)
                ? json_decode($period->price_ranges, true)
                : $period->price_ranges;

            $rangeStart = $currentDate->copy();
            $rangeEnd = min(Carbon::parse($period->end_date), $endDate);

            // ✅ INCLUSIF
            // $rangeDays = $rangeStart->diffInDays($rangeEnd->copy()->addDay());
            $rangeDays = $rangeStart->floatDiffInRealHours($rangeEnd) / 24;


            $matchedPrice = collect($ranges)->first(function ($range) use ($rangeDays) {
                return $rangeDays >= $range['min_days'] && $rangeDays <= $range['max_days'];
            });

            $pricePerDay = $matchedPrice['price'] ?? ($period->price ?? $scooter->default_price ?? 100);
            $totalPrice += $pricePerDay * $rangeDays;

            $log[] = [
                'from' => $rangeStart->toDateString(),
                'to' => $rangeEnd->toDateString(),
                'days' => $rangeDays,
                'price_per_day' => $pricePerDay,
                'total' => $pricePerDay * $rangeDays,
                'period_id' => $period->id
            ];

            $currentDate = $rangeEnd->copy()->addDay(); // avance proprement
        }


        return response()->json([
            'realPrice' => $totalPrice,
            'price' => $totalPrice,
            'breakdown' => $log,
            'request' => $request->all(),
        ]);
    }

    // DSK
    public function _getPriceForDays(Request $request)
    {
        $scooter = Scooter::with('pricePeriods')->findOrFail($request->scooter_id);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Modification ici: +1 pour compter les jours calendaires inclusifs
        $totalDays = $startDate->diffInDays($endDate); // + 1
        $totalPrice = 0;
        $log = [];

        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            // Trouve la période tarifaire qui contient la date actuelle
            $period = $scooter->pricePeriods->first(function ($p) use ($currentDate) {
                return Carbon::parse($p->start_date)->lte($currentDate) &&
                    Carbon::parse($p->end_date)->gte($currentDate);
            });

            if (!$period) {
                $totalPrice += $scooter->default_price ?? 100;
                $log[] = [
                    'date' => $currentDate->toDateString(),
                    'price' => $scooter->default_price ?? 100,
                    'source' => 'default',
                ];
                $currentDate->addDay();
                continue;
            }

            $ranges = is_string($period->price_ranges)
                ? json_decode($period->price_ranges, true)
                : $period->price_ranges;

            // Calcule jusqu'à quelle date cette période est applicable
            $rangeEnd = min(Carbon::parse($period->end_date), $endDate);
            $rangeStart = $currentDate->copy();
            
            // Modification ici aussi: +1 pour les jours calendaires
            $rangeDays = $rangeStart->diffInDays($rangeEnd); // + 1

            // Trouver le bon prix dans les plages
            $matchedPrice = collect($ranges)->first(function ($range) use ($rangeDays) {
                return $rangeDays >= $range['min_days'] && $rangeDays <= $range['max_days'];
            });

            $pricePerDay = $matchedPrice['price'] ?? ($period->price ?? $scooter->default_price ?? 0); //100
            $totalPrice += $pricePerDay * $rangeDays;

            $log[] = [
                'from' => $rangeStart->toDateString(),
                'to' => $rangeEnd->toDateString(),
                'days' => $rangeDays,
                'price_per_day' => $pricePerDay,
                'total' => $pricePerDay * $rangeDays,
                'period_id' => $period->id
            ];

            $currentDate = $rangeEnd->copy()->addDay();
        }

        return response()->json([
            'realPrice' => $totalPrice,
            'price' => $totalPrice,
            'breakdown' => $log,
            'request' => [
                'scooter_id' => $request->scooter_id,
                'days' => $totalDays, // Ici vous aurez maintenant 12 jours
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ],
        ]);
    }    


}
