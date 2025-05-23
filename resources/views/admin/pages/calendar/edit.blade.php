@extends('admin.app')

@section('content')
<div class="container">
    <h2>Modifier la réservation</h2>
    @include('admin.message.alert')
    <form action="{{ route('admin.calendar.update', $calendar->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-4">
                <label for="age_conducteur" class="form-label">Âge du conducteur</label>
                <input type="number" class="form-control" id="age_conducteur" name="age_conducteur" value="{{ old('age_conducteur', $calendar->age_conducteur == "" ?? '30') }}">
            </div>

            <div class="col-md-4">
                <label for="start" class="form-label">Date de début</label>
                <input type="date" class="form-control" id="start" name="start" value="{{ old('start', $calendar->start) }}">
            </div>

            <div class="col-md-4">
                <label for="end" class="form-label">Date de fin</label>
                <input type="date" class="form-control" id="end" name="end" value="{{ old('end', $calendar->end) }}">
            </div>

            @php
                // Tronquer pour garder seulement les heures et minutes (ex: '10:00')
                $start_time_value = \Illuminate\Support\Str::limit($calendar->start_time, 5, '');
                $end_time_value = \Illuminate\Support\Str::limit($calendar->end_time, 5, '');
            @endphp

            <div class="col-md-4">
                <div class="form-group">
                    <label for="start_time">Heure de début :</label>
                    <select id="start_time" name="start_time" class="form-control">
                        @for ($hour = 7; $hour <= 22; $hour++)
                            @php
                                $hour_00 = sprintf('%02d:00', $hour);
                                $hour_30 = sprintf('%02d:30', $hour);
                            @endphp
                            <option value="{{ $hour_00 }}" {{ $start_time_value == $hour_00 ? 'selected' : '' }}>{{ $hour_00 }}</option>
                            <option value="{{ $hour_30 }}" {{ $start_time_value == $hour_30 ? 'selected' : '' }}>{{ $hour_30 }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="end_time">Heure de fin :</label>
                    <select id="end_time" name="end_time" class="form-control">
                        @for ($hour = 7; $hour <= 22; $hour++)
                            @php
                                $hour_00 = sprintf('%02d:00', $hour);
                                $hour_30 = sprintf('%02d:30', $hour);
                            @endphp
                            <option value="{{ $hour_00 }}" {{ $end_time_value == $hour_00 ? 'selected' : '' }}>{{ $hour_00 }}</option>
                            <option value="{{ $hour_30 }}" {{ $end_time_value == $hour_30 ? 'selected' : '' }}>{{ $hour_30 }}</option>
                        @endfor
                    </select>
                </div>
            </div>


            <div class="col-md-4">
                <label for="montant" class="form-label">Montant</label>
                <input type="number" step="0.01" class="form-control" id="montant" name="montant" value="{{ old('montant', $calendar->montant) }}">
            </div>

            <div class="col-md-4">
                <label for="etat_paiement" class="form-label">État du paiement</label>
                <select class="form-control" id="etat_paiement" name="etat_paiement">
                    <option value="non payé" {{ old('etat_paiement', $calendar->etat_paiement) == 'non payé' ? 'selected' : '' }}>Non payé</option>
                    <option value="payé" {{ old('etat_paiement', $calendar->etat_paiement) == 'payé' ? 'selected' : '' }}>Payé</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="etat_reservation" class="form-label">État de la réservation</label>
                <select class="form-control" id="etat_reservation" name="etat_reservation">
                    <option value="en attente" {{ old('etat_reservation', $calendar->etat_reservation) == 'en attente' ? 'selected' : '' }}>En attente</option>
                    <option value="confirmée" {{ old('etat_reservation', $calendar->etat_reservation) == 'confirmée' ? 'selected' : '' }}>Confirmée</option>
                    <option value="annulée" {{ old('etat_reservation', $calendar->etat_reservation) == 'annulée' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="nombre_jours" class="form-label">Nombre de jours</label>
                <input type="number" class="form-control" id="nombre_jours" name="nombre_jours" value="{{ old('nombre_jours', $calendar->nombre_jours) }}">
            </div>

            <div class="col-md-12">
                <label for="notes_admin" class="form-label">Notes admin</label>
                <textarea class="form-control" id="notes_admin" name="notes_admin" rows="3">{{ old('notes_admin', $calendar->notes_admin) }}</textarea>
            </div>

            <div class="col-md-6">
                <label for="client_id" class="form-label">Client</label>
                <select class="form-control" id="client_id" name="client_id">
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $calendar->client_id) == $client->id ? 'selected' : '' }}>
                            {{ $client->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="scooter_id" class="form-label">Scooter</label>
                <select class="form-control" id="scooter_id" name="scooter_id">
                    @foreach($scooters as $scooter)
                        <option value="{{ $scooter->id }}" {{ old('scooter_id', $calendar->scooter_id) == $scooter->id ? 'selected' : '' }}>
                            {{ $scooter->modele }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-secondary">Enregistrer les modifications</button>
            <a href="{{ route('admin.calendar.list') }}" class="btn btn-light">Annuler</a>
        </div>
    </form>
</div>
@endsection
