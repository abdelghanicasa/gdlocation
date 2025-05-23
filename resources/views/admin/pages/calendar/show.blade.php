@extends('admin.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card iq-card">
                <div class="card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">
                            <!-- <i class="fa-regular fa-motorcycle text-primary me-2"></i> -->
                            Détails de la réservation #{{ $reservation->reference }} 
                        </h4>
                    </div>
                    <!-- <div class="d-flex align-items-center">
                        <span class="badge bg-{{ $reservation->etat_reservation === 'confirmé' ? 'success' : 'warning' }} me-2">
                            {{ $reservation->etat_reservation }}
                        </span>
                        <span class="badge bg-{{ $reservation->etat_paiement === 'payé' ? 'success' : 'danger' }}">
                            {{ $reservation->etat_paiement }}
                        </span>
                    </div> -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Colonne Moto -->
                        <div class="col-md-5">
                            <div class="card iq-card">
                                <div class="card-body">
                                    <h5 class="card-title text-light mb-4">
                                        <i class="fas fa-bike me-2"></i>
                                        Nom client : {{ $reservation->title }}
                                    </h5>
                                    
                                    <!-- Carousel des images -->
                                    <div id="motoCarousel" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner rounded">
                                            @foreach($motoImages as $key => $image)
                                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                <img src="{{ $image }}" class="d-block w-100" alt="Moto {{ $key+1 }}">
                                            </div>
                                            @endforeach
                                        </div>
                                        <!-- <button class="carousel-control-prev" type="button" data-bs-target="#motoCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#motoCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button> -->
                                    </div>
                                    
                                    <div class="mt-4">
                                        <h6 class="mb-3">Description</h6>
                                        <p class="text-muted">{{ $reservation->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Colonne Informations -->
                        <div class="col-md-7">
                            <div class="card iq-card">
                                <div class="card-body">
                                    <h5 class="card-title text-light mb-4">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Informations de réservation
                                    </h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h6 class="text-muted mb-2">Période de location</h6>
                                                <p>
                                                    <i class="far fa-calendar-alt me-2"></i>
                                                    Du <strong>{{ date('d/m/Y', strtotime($reservation->start)) }}</strong><br>
                                                    au <strong>{{ date('d/m/Y', strtotime($reservation->end)) }}</strong>
                                                </p>
                                                <p>
                                                    <i class="far fa-clock me-2"></i>
                                                    De <strong>{{ substr($reservation->start_time, 0, 5) }}</strong> à <strong>{{ substr($reservation->end_time, 0, 5) }}</strong>
                                                </p>
                                                <p>
                                                    <i class="fas fa-calendar-day me-2"></i>
                                                    Durée: <strong>{{ $reservation->nombre_jours }} jours</strong>
                                                </p>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <h6 class="text-muted mb-2">Lieu de prise en charge</h6>
                                                <p>
                                                    <i class="fas fa-map-marker-alt me-2"></i>
                                                    {{ $reservation->location ?? ''}}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h6 class="text-muted mb-2">Informations client</h6>
                                                <p>
                                                    <i class="fas fa-user me-2"></i>
                                                    <strong>{{ $reservation->prenom }} {{ $reservation->nom }}</strong><br>
                                                    Âge conducteur: {{ $reservation->age_conducteur }} ans
                                                </p>
                                                <p>
                                                    <i class="fas fa-phone me-2"></i>
                                                    {{ $reservation->tel }}
                                                </p>
                                                <p>
                                                    <i class="fas fa-envelope me-2"></i>
                                                    {{ $reservation->email }}
                                                </p>
                                                <p>
                                                    <i class="fas fa-home me-2"></i>
                                                    {{ $reservation->adresse  ?? ''}}<br>
                                                    {{ $reservation->code_postal }} {{ $reservation->ville }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="mb-4">
                                                <h6 class="text-muted mb-2">Référence & Notes</h6>
                                                <p>
                                                    <i class="fas fa-hashtag me-2"></i>
                                                    Référence: <strong>{{ $reservation->reference }}</strong>
                                                </p>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <h6 class="card-title">
                                                            <i class="fas fa-sticky-note me-2"></i>
                                                            Commentaires
                                                        </h6>
                                                        <p class="card-text" style="color: black;">{{ $reservation->notes_admin ?? 'Aucune note' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Boutons d'action -->
                    <!-- <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-between">
                            <a href="{{ route('admin.calendar.list') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Retour à la liste
                            </a>
                            <div class="btn-group">
                                <button class="btn btn-primary">
                                    <i class="fas fa-print me-2"></i> Imprimer
                                </button>
                                <button class="btn btn-success">
                                    <i class="fas fa-envelope me-2"></i> Envoyer confirmation
                                </button>
                                <button class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i> Modifier
                                </button>
                            </div>
                        </div>
                    </div> -->
                    <a href="{{ route('admin.calendar.list') }}" class="btn btn-light">Retour</a>
                </div>
                
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .carousel-item img {
        max-height: 400px;
        object-fit: contain;
    }
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .iq-card-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .text-muted {
        color: #6c757d !important;
    }
</style>
@endpush