@extends('admin.app')

@section('content')
<div class="iq-card">
    <div class="iq-card-header d-flex justify-content-between">
        <div class="iq-header-title">
            <h4 class="card-title text-light">Liste des scooters</h4>
        </div>
        <a href="{{ route('scooters.create') }}" class="btn btn-light">
            <i class="fa fa-plus"></i> Ajouter un scooter
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="iq-card-body">
        <div class="listResa table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <!-- <th>Photo</th> -->
                        <th>Modèle</th>
                        <th>Quantités</th>
                        <!-- <th>Prix journalier</th> -->
                        <!-- <th>Plaque</th> -->
                        <th>Statut</th>
                        <!-- <th>Kilométrage</th> -->
                        <!-- <th>Année</th> -->
                        <th>Réservations</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($scooters as $scooter)
                    <tr>

                        <!-- <td><img src="{{ $scooter->photo_url }}" width="50" class="img-thumbnail"></td> -->
                        <td>{{ $scooter->modele }}</td>
                        <td>{{ $scooter->nbr_scooter ?? 0 }} </td>
                        <!-- <td class="">
                            <span 
                                class="badge bg-warnings text-dark fs-2 m-xl-0" 
                                style="font-size: 16px;">{{ $scooter->prix_journalier }} €
                            </span> 
                        </td> -->
                        <!-- <span class="badge bg-warning text-dark fs-2">€/Jour</span></td> -->
                        <!-- <td>{{ $scooter->plaque_immatriculation }}</td> -->
                        <td>
                            <span class="badge bg-{{ [
                                'disponible' => 'successs',
                                'non disponible' => 'warnings',
                                'hors_service' => 'danger'
                            ][$scooter->statut] }}">
                                {{ ucfirst($scooter->statut) }}
                            </span>
                        </td>
                        <!-- <td>{{ number_format($scooter->kilometrage, 0, ',', ' ') }} km</td> -->
                        <!-- <td>{{ $scooter->annee }}</td> -->
                        <td>{{ $scooter->reservations_count }}</td>
                        <td>
                            <a href="{{ route('scooters.edit', $scooter->id) }}" class="btn btn-sm btn-light">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('scooters.destroy', $scooter->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection