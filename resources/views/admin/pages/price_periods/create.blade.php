@extends('admin.app')

@section('content')
<div class="col-sm-12">
    <div class="mb-4 card iq-card">
        <div class="card-body">
            <h4 class="mb-4">Ajouter une période de prix</h4>

            <form action="{{ route('price_periods.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="scooter_id">Scooter</label>
                    <select name="scooter_id" id="scooter_id" class="form-control" required>
                        @foreach($scooters as $scooter)
                            <option value="{{ $scooter->id }}">{{ $scooter->caracteristiques }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="period_name">Nom de la période</label>
                    <input type="text" name="period_name" id="period_name" class="form-control" value="" required>
                </div>

                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="start_date">Date de début</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="end_date">Date de fin</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="" required>
                    </div>
                </div>

                <div class="mb-3">
                    <!-- <label for="price">Prix (€) (Vide par defaut)</label> -->
                    <input type="hidden" value="0" step="0.01" name="price" id="price" class="form-control" required>
                </div>
                <div class="mb-3">
                <label for="price_ranges">Plages de jours avec prix</label>

                <table class="table" id="price-range-table">
                    <thead>
                        <tr>
                            <th>De (jours)</th>
                            <th>À (jours)</th>
                            <th>Prix (€)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rangée initiale -->
                        <tr>
                            <td><input type="text" name="price_ranges[0][min_days]" class="form-control" required></td>
                            <td><input type="text" name="price_ranges[0][max_days]" class="form-control" required></td>
                            <td><input type="text" name="price_ranges[0][price]" class="form-control" required></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-range">Supprimer</button></td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" id="add-range" class="btn btn-light btn-sm">+ Ajouter une plage</button>
            </div>

                <div class="mb-5"></div>
                <button type="submit" class="btn btn-secondary">Enregistrer</button>
                <a href="{{  route('price_periods.index') }}" class="btn btn-light">Annuler</a>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<!-- <script>
  flatpickr("#end_date", {
    locale: "fr", // Activation du français
    dateFormat: "d/m/Y", // Format jj/mm/aaaa
    allowInput: true, // Permettre la saisie manuelle
    // Autres options utiles :
    altInput: true,
    altFormat: "j F Y", // Affichage alternatif (ex: "13 mai 2025")
    minDate: "today", // Date minimale = aujourd'hui
    disableMobile: "true" // Désactive le picker natif sur mobile
  });
</script> -->
<script>
    let rangeIndex = 1;

    document.getElementById('add-range').addEventListener('click', function () {
        const table = document.querySelector('#price-range-table tbody');

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" name="price_ranges[${rangeIndex}][min_days]" class="form-control" required></td>
            <td><input type="text" name="price_ranges[${rangeIndex}][max_days]" class="form-control" required></td>
            <td><input type="text" name="price_ranges[${rangeIndex}][price]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-range">Supprimer</button></td>
        `;

        table.appendChild(newRow);
        rangeIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-range')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endpush

@endsection
