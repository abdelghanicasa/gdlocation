{{-- resources/views/admin/scooters/create.blade.php --}}
@extends('admin.app')

@section('content')
<div class="iq-card">
    <div class="iq-card-header">
        <h4 class="card-title">Ajouter un nouveau scooter</h4>
    </div>
    <div class="iq-card-body">
        <form method="POST" action="{{ route('scooters.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Modèle *</label>
                        <input type="text" class="form-control" name="modele" value="{{ old('modele') }}" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre de scooter *</label>
                        <input type="hidden" class="form-control" name="plaque_immatriculation" value="0000000000">
                        <input type="hidden"  class="form-control" name="prix_journalier" value="00">
                        <input type="hidden" class="form-control" name="kilometrage" value="0000">
                        <input type="hidden" aria-valuemax="0000" class="form-control" name="annee" value="2000">
                        <input type="number" class="form-control" name="nbr_scooter" value="{{ old('nbr_scooter') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Statut *</label>
                        <select class="form-control" name="statut" required>
                            <option value="disponible">Disponible</option>
                            <option value="non disponible">Non disponible</option>
                            <option value="hors_service">Hors service</option>
                        </select>
                    </div>
                </div>
                
            </div>

            <div class="form-group">
                <label>Note</label>
                <textarea class="form-control" name="caracteristiques" rows="3">{{ old('caracteristiques') }}</textarea>
            </div>

            <button type="submit" class="btn btn-secondary">
                Enregistrer
            </button>
            <a href="{{ route('scooters.index') }}" class="btn btn-light">
                 Annuler
            </a>
        </form>
    </div>
</div>
@endsection