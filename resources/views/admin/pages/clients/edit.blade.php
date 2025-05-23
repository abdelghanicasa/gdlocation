@extends('admin.app')

@section('content')
<div class="col-sm-12">
    <div class="mb-4 card iq-card">
        <div class="card-body">
            <form method="POST" action="{{ route('clients.update', $client->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Modifier le client</h5>
                    <a href="{{ route('clients.index') }}" class="btn-close" aria-label="Fermer"></a>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" value="{{ old('nom', $client->nom) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $client->prenom) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="tel" class="form-control" value="{{ old('tel', $client->tel) }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $client->adresse) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ville</label>
                            <input type="text" name="ville" class="form-control" value="{{ old('ville', $client->ville) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Code postal</label>
                            <input type="text" name="code_postal" class="form-control" value="{{ old('code_postal', $client->code_postal) }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" onclick="window.history.back()">Annuler</button>
                    <button type="submit" class="btn btn-light"><i class="fa fa-edit"></i> Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
