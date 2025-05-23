@extends('frontend.layouts.app')

@section('title', 'Session expirée')

@section('content')
<div class="container text-center py-5">
    <!-- ⏰ -->
    <h1 class="display-4"> Session expirée</h1>
    <p class="lead">Votre session a expiré pour des raisons de sécurité.</p>
    <p>Veuillez rafraîchir la page ou vous reconnecter.</p>
    <!-- <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Revenir en arrière</a> -->
    <a href="{{ route('accueil') }}" class="btn btn-outline-secondary mt-3">Accueil</a>
</div>
@endsection
