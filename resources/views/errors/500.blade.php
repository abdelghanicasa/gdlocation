@extends('frontend.layouts.app')

@section('title', 'Erreur serveur')

@section('content')
<div class="container text-center py-5">
    <h1 class="display-4">500 - Erreur interne du serveur</h1>
    <p class="lead">Une erreur inattendue est survenue. Nous travaillons à la corriger.</p>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Retour à l'accueil</a>
</div>
@endsection
