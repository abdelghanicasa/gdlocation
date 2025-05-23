@extends('admin.app')

@section('content')
<div class="container">
    <h2>Modifier le code promo</h2>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Une erreur est survenue :</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <form method="POST" action="{{ route('promos.update', $promo) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Code</label>
            <input type="text" name="code" class="form-control" value="{{ $promo->code }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Montant de réduction (€)</label>
            <input type="number" name="discount" class="form-control" step="0.01" value="{{ substr($promo->discount, 0,2) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date d’expiration</label>
            <input type="date" name="expires_at" class="form-control" value="{{ $promo->expires_at?->format('Y-m-d') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Limite d’utilisation</label>
            <input type="number" name="usage_limit" class="form-control" value="{{ $promo->usage_limit }}">
        </div>

        <div class="form-check">
            <input type="hidden" name="active" value="0"> {{-- valeur envoyée si non coché --}}
            <input class="form-check-input" type="checkbox" name="active" id="active"
                value="1" {{ old('active', $promo->active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="active">
                Actif
            </label>
        </div>

        <button type="submit" class="btn btn-secondary">Mettre à jour</button>
        <a href="{{ route('promos.index') }}" class="btn btn-light">Annuler</a>
    </form>
</div>
@endsection
