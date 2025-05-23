@extends('admin.app')

@section('content')
<div class="iq-card">
    <div class="iq-card-header">
        <h4 class="card-title">Liste des paiements</h4>
    </div>
    <div class="iq-card-body">
        @if($paiements->isEmpty())
            <div class="alert alert-info">Aucun paiement trouvé.</div>
        @else
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Réservation</th>
                        <th>Montant</th>
                        <th>Méthode</th>
                        <th>Référence</th>
                        <th>Statut</th>
                        <th>Date de paiement</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paiements as $paiement)
                    <tr>
                        <td>{{ $paiement->id }}</td>
                        <td>
                            @if ($paiement->calendar)
                                Réservation #{{ $paiement->calendar->id }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ number_format($paiement->montant, 2) }} €</td>
                        <td>{{ $paiement->methode }}</td>
                        <td>{{ $paiement->reference ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $paiement->statut == 'réussi' ? 'success' : 'warning' }}">
                                {{ ucfirst($paiement->statut) }}
                            </span>
                        </td>
                        <td>{{ $paiement->date_paiement ? $paiement->date_paiement->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $paiement->notes ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $paiements->links() }}
        @endif
    </div>
</div>
@endsection