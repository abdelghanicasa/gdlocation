@extends('admin.app')

@section('content')
<div class="container">
    <h2>Codes Promo</h2>
        <a class="btn btn-light mb-3" href="{{ route('promos.create') }}">
            + Nouveau code promo
        </a>
    <table id="listResa" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Code</th>
            <th>Réduction (€)</th>
            <th>Expiration</th>
            <th>Limite</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($promos as $promo)
                <tr>
                    <td>{{ $promo->code }}</td>
                    <td>{{ \AppHelper::cleanNumber($promo->discount) }}</td>
                    <td>{{ AppHelper::formatDate($promo->expires_at) }}</td>
                    <td>{{ $promo->usage_limit ?? 'Illimité' }}</td>
                    <td>    
                        <span class="badge {{ $promo->active ? 'bg-successs' : 'bg-warnings' }}">
                            {{ $promo->active ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('promos.edit', $promo) }}" class="btn btn-sm btn-light">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('promos.destroy', $promo) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce code ?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


@push('scripts')
<script>
document.getElementById('promoForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let form = e.target;
    let data = new FormData(form);

    fetch("{{ route('promos.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('[name=_token]').value,
        },
        body: data
    })
    .then(response => {
        if (!response.ok) throw new Error("Erreur lors de la création.");
        return response.json();
    })
    .then(() => {
        location.reload(); // recharge la page pour voir le nouveau code (ou tu peux ajouter dynamiquement)
    })
    .catch(error => alert(error.message));
});
</script>

@endpush
@endsection
