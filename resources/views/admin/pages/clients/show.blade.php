@extends('admin.app')

@section('content')
<div class="col-sm-12">

    <div class="iq-card">
        <div class="iq-card-header" style="padding-top: 20px;">
            
            <h4 class="card-title">
                Fiche client : {{ $client->nom }} {{ $client->prenom }}
            </h4>

        </div>
        <div class="iq-card-body">
            <div class="mb-4">
                <strong>Email :</strong> {{ $client->email }}<br>
                <strong>Téléphone :</strong> {{ $client->telephone }}<br>
                <strong>Adresse :</strong> {{ $client->adresse }}<br> <!-- si tu as un champ adresse -->
            </div>

            <div class="mb-4">
                <h5>Historique des locations</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Référence</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historiqueLocations as $location)
                        <tr>
                            <td>{{ $location->date }}</td> <!-- Utilise le bon champ pour la date -->
                            <td>{{ $location->montant }} </td>
                            <td>{{ $location->reference }}</td> <!-- Utilise le bon champ pour la référence -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mb-4">
                <h5>Total dépensé : {{ $totalDepense }} </h5>
            </div>

            <div>
                <h5>Dernière réservation</h5>
                @if($derniereReservation)
                    <p><strong>Date :</strong> {{ $derniereReservation->date }}</p>
                    <p><strong>Montant :</strong> {{ $derniereReservation->montant }} </p>
                @else
                    <p>Aucune réservation trouvée.</p>
                @endif
            </div>
            <a href="{{ route('clients.index') }}" class="btn btn-light me-2 btn-filter">
                <i class="fa fa-times"></i> Retour
            </a>
        </div>
    </div>
</div>
@endsection
