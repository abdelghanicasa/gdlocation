@extends('admin.app')

@section('content')
<div class="col-sm-12">
    <div class="mb-4 card iq-card">
        <div class="card-body">
            <h4 class="card-title text-light">Gestion des Tarifs</h4>

            <a href="{{ route('price_periods.create') }}" class="btn btn-light mb-3"><i class="fa fa-plus"></i>Ajouter une période</a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @foreach($scootersWithPeriods as $scooter)
                <h5 class="text-white mt-4">{{ $scooter->modele ?? 'Scooter sans modèle' }}</h5>

                @if($scooter->pricePeriods->isEmpty())
                    <p class="text-muted">Aucune période tarifaire définie pour ce scooter.</p>
                @else
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Période</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($scooter->pricePeriods as $period)
                                <tr>
                                    <td>{{ $period->start_date }} à {{ $period->end_date }} ({{ $period->period_name }})</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('price_periods.edit', $period) }}" class="btn btn-light btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm delete-button" data-id="{{ $period->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $period->id }}" action="{{ route('price_periods.destroy', $period) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endforeach

        </div>
    </div>  
</div>

@push('scripts')    
<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function() {
            const periodId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Confirmer la suppression ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + periodId).submit();
                }
            });
        });
    });
</script>
@endpush
@endsection
