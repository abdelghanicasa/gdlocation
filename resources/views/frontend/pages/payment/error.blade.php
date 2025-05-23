@extends('frontend.layouts.main')

@section('content')
<div class="container">
    <div class="alert alert-danger">
        <h4>Paiement échoué</h4>
        <p>Erreur : {{ $error }}</p>
        <a href="{{ route('reservation') }}" class="btn btn-primary">Réessayer</a>
    </div>
</div>
@endsection