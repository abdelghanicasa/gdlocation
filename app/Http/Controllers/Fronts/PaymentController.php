<?php

namespace App\Http\Controllers\Fronts;

// namespace App\Http\Controllers;

use App\Services\SogecommerceService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\PaymentConfirmationMail;
use App\Models\Calendar;
use Illuminate\Support\Facades\DB;
// use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator; // Add this import


class PaymentController extends Controller
{
    protected $sogecommerce;

    public function __construct(SogecommerceService $sogecommerce)
    {
        $this->sogecommerce = $sogecommerce;
    }

    public function showPaymentForm(Request $request)
    {

        // Récupération des données depuis la session OU depuis la requête POST
        $paymentData = session('payment_data') ?? $request->all();
        
        // Validation des données
        $validator = Validator::make($paymentData, [
            'reference' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'customer_email' => 'required|email'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('reservation.create')
                   ->withErrors($validator)
                   ->withInput();
        }
    
        // Configuration du paiement
        $config = $this->sogecommerce->getClientConfiguration();
    
        return view('frontend.pages.payment.form', [
            'jsUrl' => $config['jsUrl'],
            'publicKey' => $config['publicKey'],
            'apiUrl' => $config['apiUrl'],
        ]);
    }

    public function processPayment(Request $request)
    {
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'email' => 'required|email'
        ]);
        Log::debug('Données reçues:', $validated);

        try {
            $paymentSession = $this->sogecommerce->createPaymentSession([
                'amount' => $validated['amount'],
                'email' => $validated['email'],
                'orderId' => 'CMD-' . time()
            ]);
    
            Log::debug('Réponse Sogecommerce :', $paymentSession);
    
            if (empty($paymentSession['answer']['formToken'])) {
                throw new \Exception('Token non reçu de Sogecommerce');
            }
    
            return view('frontend.pages.payment.process', [
                'formToken' => $paymentSession['answer']['formToken'],
                'publicKey' => config('sogecommerce.public_key_test'),
                'jsUrl' => config('sogecommerce.js_url')
            ]);
    
        } catch (\Exception $e) {
            Log::error('Erreur paiement : ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de la création du paiement');
        }
    }

    public function paymentReturn(Request $request)
    {
        if (!$this->sogecommerce->verifyIpnSignature($request->all())) {
            return view('frontend.pages.payment.result', [
                'success' => false,
                'error' => 'Signature invalide',
            ]);
        }

        return view('payment.result', [
            'success' => $request->kr_status === 'PAID',
            'data' => $request->all(),
        ]);
    }

    public function paymentCallback(Request $request)
    {
        if (!$this->sogecommerce->verifyIpnSignature($request->all())) {
            Log::error('Sogecommerce IPN signature verification failed', $request->all());
            return response('Invalid signature', 400);
        }

        // Traitez le paiement ici
        $orderId = $request->kr_order_id;
        $status = $request->kr_status;
        
        Log::info("Sogecommerce IPN received for order $orderId with status $status");

        // Mettez à jour votre base de données
        
        return response('OK', 200);
    }






    /*************************** PQYMENT NE */
    public function redirectToSogecommerce($id)
    {
        
        $reservation = Calendar::findOrFail($id);
        // dd($reservation->reference);
        $transId = str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $transDate = gmdate("YmdHis");
    
        $fields = [
            'vads_action_mode' => 'INTERACTIVE',
            'vads_amount' => $reservation->montant * 100, // en centimes
            'vads_currency' => 978,
            'vads_payment_config' => 'SINGLE',
            'vads_site_id' => '51647543',
            'vads_trans_date' => $transDate,
            'vads_trans_id' => $transId,
            'vads_version' => 'V2',
            'vads_page_action' => 'PAYMENT',
            'vads_ctx_mode' => 'PRODUCTION', // config('services.sogecommerce.mode')
            'vads_order_id' => $reservation->reference,
            'vads_cust_email' => $reservation->email,
            'vads_url_success' => route('paiement.success'),
            'vads_url_cancel' => route('paiement.cancel'),
            'vads_url_error' => route('paiement.error'),
            'vads_url_refused' => route('paiement.refused'),
        ];
    
        $fields['signature'] = $this->generateSignature($fields, 'R7wsDyGLoXtBCuI4'); //oCTLtnzZX7zOBlmM   //R7wsDyGLoXtBCuI4
    
        return view('frontend.pages.payment.redirect', compact('fields'));
    }
    
public function paymentSuccess(Request $request)
{
    // Récupérer la référence de la réservation en session
    $reference = session('reservation_reference');

    if (!$reference) {
        abort(404, "Référence de réservation non trouvée en session.");
    }

    // Récupérer la réservation avec les infos demandées
    // Je suppose que tu as une table `reservations` avec nom, prenom, reference, scooter_id, montant
    // Et une table scooters avec id et modele
    // Sinon adapte selon ta structure

    $reservation = DB::table('calendars')
        ->join('scooters', 'calendars.scooter_id', '=', 'scooters.id')
        ->select(
        'calendars.nom',
        'calendars.prenom',
        'calendars.reference',
        'scooters.modele as scooter_modele',
        'calendars.montant',
        'calendars.start as date_depart',
        'calendars.end as date_retour',
        'calendars.end_time as heure_depart',
        'calendars.end_time as heure_retour'         
        )
        ->where('calendars.reference', $reference)
        ->first();

    if (!$reservation) {
        abort(404, "Réservation introuvable pour la référence $reference");
    }

    Mail::to($reservation->client->email)->send(new PaymentConfirmationMail($reservation));

    // Si tu veux passer aussi les infos bancaires du $request, adapte ici
    // Exemple : $vadsActionMode = $request->input('vads_action_mode');

    return view('frontend.pages.payment.success', [
        'reservation' => $reservation,
        // 'vadsActionMode' => $request->input('vads_action_mode'), // etc.
    ]);
}


    

    // Fonction pour calculer la signature attendue
    private function computeSignature($data, $secretKey)
    {
        // Construire la chaîne à signer à partir des paramètres
        $stringToSign = implode('+', [
            $data['vads_action_mode'],
            $data['vads_amount'],
            $data['vads_ctx_mode'],
            $data['vads_currency'],
            $data['vads_cust_email'],
            $data['vads_order_id'],
            $data['vads_page_action'],
            $data['vads_payment_config'],
            $data['vads_site_id'],
            $data['vads_trans_date'],
            $data['vads_trans_id'],
            $data['vads_url_cancel'],
            $data['vads_url_error'],
            $data['vads_url_refused'],
            $data['vads_url_success'],
            $data['vads_version'],
        ]);

        // HMAC-SHA-256
        return hash_hmac('sha256', $stringToSign, $secretKey);
    }

    private function generateSignature(array $fields, string $secretKey)
    {
        ksort($fields);
        $signatureString = '';
        foreach ($fields as $value) {
            $signatureString .= $value . '+';
        }
        $signatureString .= $secretKey;

        return base64_encode(hash_hmac('sha256', $signatureString, $secretKey, true));
    }

    public function success(Request $request)
    {
        return "Paiement réussi !";
    }

    public function cancel(Request $request)
    {
        // return redire('frontend.pages.accueil');
        return redirect()->route('accueil');
    }

    public function error(Request $request)
    {
        return "Erreur lors du paiement.";
    }

    public function refused(Request $request)
    {
        return "Paiement refusé.";
    }
}