@extends('frontend.layouts.app')

@section('title', 'Accès refusé')

@section('content')
<div class="container text-center py-5">
    <h1 class="display-4">403 - Accès refusé</h1>
    <p class="lead">Vous n'avez pas la permission d'accéder à cette page.</p>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Retour à l'accueil</a>
</div>
@endsection
