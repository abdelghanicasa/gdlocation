@extends('admin.app')

@section('content')
<div class="iq-card">
    <div class="iq-card-header">
        <h4 class="card-title">Vérification disponibilité</h4>
    </div>
    <div class="iq-card-body">
        <form method="GET" action="{{ route('scooters.disponibilite') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date de début</label>
                        <input type="date" class="form-control" name="date_debut" value="{{ $dateDebut ?? '' }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date de fin</label>
                        <input type="date" class="form-control" name="date_fin" value="{{ $dateFin ?? '' }}" required>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Vérifier</button>
                </div>
            </div>
        </form>

        @if(isset($scootersDisponibles))
        <div class="mt-4">
            <h5>Scooters disponibles du {{ $dateDebut }} au {{ $dateFin }}</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Modèle</th>
                            <th>Plaque</th>
                            <th>Kilométrage</th>
                            <th>Année</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($scootersDisponibles as $scooter)
                        <tr>
                            <td>{{ $scooter->modele }}</td>
                            <td>{{ $scooter->plaque_immatriculation }}</td>
                            <td>{{ number_format($scooter->kilometrage, 0, ',', ' ') }} km</td>
                            <td>{{ $scooter->annee }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Aucun scooter disponible pour cette période</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection