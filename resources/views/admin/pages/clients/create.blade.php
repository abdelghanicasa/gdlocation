@extends('admin.app')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4>Ajouter un client</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('clients.store') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nom</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Prénom</label>
                        <input type="text" name="prenom" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Téléphone</label>
                        <input type="text" name="tel" class="form-control" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Adresse</label>
                        <input type="text" name="adresse" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Ville</label>
                        <input type="text" name="ville" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Code postal</label>
                        <input type="text" name="code_postal" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>

@endsection
