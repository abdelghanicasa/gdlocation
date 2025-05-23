<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ScooterController;
use App\Http\Controllers\PostController;

// Front
use App\Http\Controllers\Fronts\FrontendController;
use App\Http\Controllers\Fronts\PaymentController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PricePeriodController;
use App\Http\Controllers\PromoCodeController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Support\Facades\Auth;


// ->middleware(['auth'])
Route::middleware(['auth'])->prefix('panel')->group(function () {

    // DasboArd
    Route::get('/', function () {
        return view('admin.dashboard');})->name('panel');
    
    Route::get('/', [DashboardController::class, 'index'])->name('panel');


    // Réservations
    Route::get('/import-reservations', [CalendarController::class, 'showImportForm'])->name('reservations.import.form');
    Route::post('/import-reservations', [CalendarController::class, 'cstoreImport'])->name('reservations.import.cstore');

    Route::get('/Reservations', [CalendarController::class, 'showCalendar'])->name('reservations'); 
    Route::get('/Reservations/list', [CalendarController::class, 'list'])->name('admin.calendar.list');

    Route::get('/Reservations/{id}/edit', [CalendarController::class, 'edit'])->name('admin.calendar.edit');
    Route::put('/Reservations/{id}', [CalendarController::class, 'update'])->name('admin.calendar.update');

    Route::get('/Reservations/{id}', [CalendarController::class, 'show'])->name('admin.calendar.show');
    Route::get('/Reservations/{reservation}/invoice', [CalendarController::class, 'invoice'])->name('admin.calendar.invoice');
    Route::get('/reservations/{reservation}/invoice', [CalendarController::class, 'generateInvoice'])->name('admin.calendar.generate');
    Route::post('/reservations/{id}/etat', [CalendarController::class, 'updateEtatReservation'])->name('admin.calendar.updateEtat');
    Route::get('/reservations/export', [CalendarController::class, 'export'])->name('admin.calendar.export');
    Route::delete('/calendar/{id}', [CalendarController::class, 'destroy'])->name('calendar.destroy');
    Route::delete('/calendar/{id}', [CalendarController::class, 'destroyList'])->name('calendar.destroyinList');


    // Routes clients
    // Liste des clients
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    // Créer un nouveau client
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');

    // Enregistrer un nouveau client
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

    // Détails d'un client
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
    
    // Routes scooters
    Route::resource('scooters', ScooterController::class)->except(['show']);
    Route::get('scooters/disponibilite', [ScooterController::class, 'disponibilite'])->name('scooters.disponibilite');

    // Routes for managing pages
    Route::resource('pages', \App\Http\Controllers\PageController::class);

    // Liste des paiements
    Route::get('paiements', [PaiementController::class, 'index'])->name('admin.paiements.index');
    
    // Génération de facture PDF
    Route::get('/{paiement}/facture', [PaiementController::class, 'genererFacture'])
        ->name('admin.paiements.facture');
    
    // // Export Excel
    Route::get('/export', [PaiementController::class, 'exporter'])
        ->name('admin.paiements.export');
    
    // // Webhook pour notifications de paiement (ex: Stripe)
    Route::post('/webhook', [PaiementController::class, 'handleWebhook'])
        ->name('admin.paiements.webhook')
        ->withoutMiddleware(['auth', 'verified']);
    
    // // Marquer comme payé
    Route::patch('/{paiement}/payer', [PaiementController::class, 'marquerPaye'])
        ->name('admin.paiement.payer');
    
    // // Annuler un paiement
    Route::delete('/{paiement}/annuler', [PaiementController::class, 'annuler'])
        ->name('admin.paiement.annuler');
    
    // // Route publique pour téléchargement de facture (avec token de sécurité)
    Route::get('/facture/{paiement}/{token}', [PaiementController::class, 'telechargerFacture'])->name('public.facture');
  
    // posts
    Route::resource('posts', PostController::class);

    Route::get('/company', [ConfigController::class, 'company'])->name('company');
    Route::put('/company', [ConfigController::class, 'updateCompany'])->name('company.update');
    
    // tarifications
    Route::resource('price_periods', PricePeriodController::class);


    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::get('/events', [CalendarController::class, 'getEvents'])->name('events.get');
    Route::post('/events', [CalendarController::class, 'cstore'])->name('events.store');
    Route::put('/events/{id}', [CalendarController::class, 'update']);
    Route::delete('/events/{id}', [CalendarController::class, 'destroy']);
    // routes/web.php ou routes/api.php
    Route::get('/calculate-price', [CalendarController::class, 'calculatePrice']);

    Route::resource('promos', PromoCodeController::class);
});


/******************************** My ROUTES FRONTs ******************************************************* */

    Route::get('/', [FrontendController::class, 'accueil'])->name('accueil');

    Route::get('/scooter', [FrontendController::class, 'scooter'])->name('scooter');
    
    /* *************                ****************** */
    Route::post('reservation', [FrontendController::class, 'reservation'])->name('reservation');
    
    Route::get('reservation', function() {
        return redirect('/')->with('error', 'Veuillez utiliser le formulaire de réservation.');
    })->name('reservation.error');

    Route::post('reservation/create', [FrontendController::class, 'createReservation'])->name('reservation.create');
    /* **************               ***************** */
    
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
    Route::get('/a-propos', [FrontendController::class, 'aPropos'])->name('a_propos');
    Route::get('/conditions', [FrontendController::class, 'condition'])->name('condition');
    Route::get('/terms', [FrontendController::class, 'terms'])->name('terms');

    // Paiement
    Route::post('/payment/response', [FrontendController::class, 'handlePaymentResponse'])->name('payment.response');
    Route::post('/payment/ipn', [FrontendController::class, 'handlePaymentNotification'])->name('payment.ipn');


    Route::post('/contact', [FrontendController::class, 'sendContactForm'])->name('contact.submit');


    Route::get('/paiement/sogecommerce/{id}', [PaymentController::class, 'redirectToSogecommerce'])->name('paiement.sogecommerce');
    Route::get('/paiement/success', [PaymentController::class, 'paymentSuccess'])->name('paiement.success');
    Route::get('/paiement/cancel', [PaymentController::class, 'cancel'])->name('paiement.cancel');
    Route::get('/paiement/error', [PaymentController::class, 'error'])->name('paiement.error');
    Route::get('/paiement/refused', [PaymentController::class, 'refused'])->name('paiement.refused');

    Route::post('/verify-discount', [PromoCodeController::class, 'verify'])->name('promo.verify');
    
    Route::post('/get-scooter-price', [FrontendController::class, 'getPriceForDays'])->name('scooter.price');

    Auth::routes(['register' => false]);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    Route::get('/panel', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
