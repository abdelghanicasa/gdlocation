@extends('admin.app')

@section('content')
<div class="container">
    <h2>Importer les réservations</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Affichage des erreurs --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservations.import.cstore') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="csv_file" class="form-label">Fichier CSV</label>
            <input type="file" class="form-control" id="csv_file" name="csv_file" required>
        </div>

        <button type="submit" class="btn btn-primary">Importer</button>
    </form>
</div>
@endsection
