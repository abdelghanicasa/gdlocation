@extends('layouts.app')

@section('content')
    <div class="container">
        @if($success)
            <div class="alert alert-success">
                <h2>Paiement réussi!</h2>
                <p>Merci pour votre paiement. Votre numéro de commande est: {{ $data['kr_order_id'] ?? '' }}</p>
            </div>
        @else
            <div class="alert alert-danger">
                <h2>Paiement échoué</h2>
                <p>Une erreur est survenue lors du traitement de votre paiement.</p>
                @if(isset($error))
                    <p>Détail: {{ $error }}</p>
                @endif
                <p>Code erreur: {{ $data['kr_error_code'] ?? '' }}</p>
            </div>
        @endif
        
        <a href="{{ url('/') }}" class="btn btn-primary">Retour à l'accueil</a>
    </div>
@endsection