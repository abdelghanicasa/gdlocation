@extends('frontend.layouts.app')

@section('title', 'Page non trouvée')

@section('content')
<div class="container text-center py-5">
    <h1 class="display-4">404 - Page non trouvée</h1>
    <p class="lead">Désolé, la page que vous cherchez n'existe pas.</p>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Retour à l'accueil</a>
</div>
@endsection
