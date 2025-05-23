@extends('admin.app')

@section('content')
<div class="iq-card">
    <div class="iq-card-header">
        <h4 class="card-title">{{ isset($scooter) ? 'Modifier' : 'Ajouter' }} un scooter</h4>
        @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    </div>
    <div class="iq-card-body">
        <form method="POST" action="{{ isset($scooter) ? route('scooters.update', $scooter->id) : route('scooters.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($scooter)) @method('PUT') @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Modèle *</label>
                        <input type="text" class="form-control" name="modele" value="{{ $scooter->modele ?? old('modele') }}" required>
                    </div>
                </div>
                <!-- <div class="col-md-3">
                    <div class="form-group">
                        <label>Plaque d'immatriculation *</label>
                        <input type="text" class="form-control" name="plaque_immatriculation" value="{{ $scooter->plaque_immatriculation ?? old('plaque_immatriculation') }}" required>
                    </div>
                </div> -->

                <div class="col-md-">
                    <div class="form-group">
                        <label>Nombre de scooter *</label>
                        <input type="text" class="form-control" name="nbr_scooter" value="{{ $scooter->nbr_scooter ?? old('nbr_scooter') }}" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Statut *</label>
                        <select class="form-control" name="statut" required>
                            <option value="disponible" {{ ($scooter->statut ?? old('statut')) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="non disponible" {{ ($scooter->statut ?? old('statut')) == 'non disponible' ? 'selected' : '' }}>En maintenance</option>
                            <option value="hors_service" {{ ($scooter->statut ?? old('statut')) == 'hors_service' ? 'selected' : '' }}>Hors service</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="row">
                
                <div class="col-md-4">
                    <!-- <div class="form-group">
                        <label>Kilométrage *</label>
                        <input type="number" class="form-control" name="kilometrage" value="{{ $scooter->kilometrage ?? old('kilometrage') }}" required>
                    </div> -->
                </div>
                <div class="col-md-4">
                    <!-- <div class="form-group">
                        <label>Année *</label>
                        <input type="number" class="form-control" name="annee" value="{{ $scooter->annee ?? old('annee') }}" required>
                    </div> -->
                </div>
            </div>

            <!-- <div class="form-group">
                <label>Photo</label>
                <input type="file" class="form-control" name="photo">
                @if(isset($scooter) && $scooter->photo)
                <div class="mt-2">
                    <img src="{{ $scooter->photo_url }}" width="100" class="img-thumbnail">
                </div>
                @endif
            </div> -->

            <div class="form-group">
                <label>Note</label>
                <textarea class="form-control" name="caracteristiques" rows="3">{{ $scooter->caracteristiques ?? old('caracteristiques') }}</textarea>
            </div>

            <button type="submit" class="btn btn-secondary">Enregistrer</button>
            <a href="{{ route('scooters.index') }}" class="btn btn-light">Annuler</a>
        </form>
    </div>
</div>
@endsection