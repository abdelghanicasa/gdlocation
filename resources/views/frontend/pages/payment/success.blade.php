@extends('frontend.layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow rounded-3 p-4 gradient-div">
        <h2 class="text-center text-light mb-4">✅ Paiement réussi !</h2>

        <div class="text-center mb-4 text-light">
            <p class="mb-1">Merci <strong>{{ $reservation->prenom }} {{ $reservation->nom }}</strong> pour votre réservation.</p>
            <p>Voici le récapitulatif de votre paiement :</p>
        </div>

        <hr>

        <div class="row mb-3 text-light">
            <div class="col-md-6">
                <p><strong>Référence :</strong> {{ $reservation->reference }}</p>
                <p><strong>Modèle du scooter :</strong> {{ $reservation->scooter_modele }}</p>
                <p><strong>Montant payé :</strong> {{ number_format($reservation->montant) }} €</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p><strong>Date de paiement :</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
                <p><strong>Méthode de paiement :</strong> Carte bancaire</p>
                <p><strong>Statut :</strong> <span class="badge bg-success">Confirmé</span></p>
            </div>
        </div>

        <hr>

        <div class="text-center mt-4 text-light">
            <p class="mb-1">Une confirmation vous a été envoyée par email.</p>
            <p>Merci de votre confiance 🙏</p>
        </div>
    </div>
</div>
@endsection
