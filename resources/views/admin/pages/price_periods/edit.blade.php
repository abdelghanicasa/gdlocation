@extends('admin.app')

@section('content')
<div class="col-sm-12">
    <div class="mb-4 card iq-card">
        <div class="card-body">
            <h4 class="mb-4">Modifier la période de prix</h4>

            <form action="{{ route('price_periods.update', $pricePeriod->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="scooter_id">Scooter</label>
                    <select name="scooter_id" id="scooter_id" class="form-control" required>
                        @foreach($scooters as $scooter)
                            <option value="{{ $scooter->id }}" {{ $scooter->id == $pricePeriod->scooter_id ? 'selected' : '' }}>
                                {{ $scooter->caracteristiques }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="period_name">Nom de la période</label>
                    <input type="text" name="period_name" id="period_name" class="form-control" value="{{ $pricePeriod->period_name }}" required>
                </div>

                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="start_date">Date de début</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $pricePeriod->start_date }}" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="end_date">Date de fin</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $pricePeriod->end_date }}" required>
                    </div>
                </div>

                <input type="hidden" value="0" step="0.01" name="price" id="price" class="form-control" required>

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
                            @foreach($priceRanges as $index => $range)
                                <tr>
                                    <td data-label="De (jours)">
                                        <input type="text" name="price_ranges[{{ $index }}][min_days]" class="form-control" value="{{ $range['min_days'] }}" required>
                                    </td>
                                    <td data-label="À (jours)">
                                        <input type="text" name="price_ranges[{{ $index }}][max_days]" class="form-control" value="{{ $range['max_days'] }}" required>
                                    </td>
                                    <td data-label="Prix (€)">
                                        <input type="text" name="price_ranges[{{ $index }}][price]" class="form-control" value="{{ $range['price'] }}" required>
                                    </td>
                                    <td data-label="Action">
                                        <button type="button" class="btn btn-danger btn-sm remove-range">Supprimer</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button type="button" id="add-range" class="btn btn-secondary btn-sm mt-2">+ Ajouter une plage</button>
                </div>

                <div class="mb-5"></div>
                <button type="submit" class="btn btn-secondary">Mettre à jour</button>
                <a href="{{ route('price_periods.index') }}" class="btn btn-light">Annuler</a>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Responsive table for mobile */
    @media (max-width: 767.98px) {
        #price-range-table thead {
            display: none;
        }
        #price-range-table, 
        #price-range-table tbody, 
        #price-range-table tr, 
        #price-range-table td {
            display: block;
            width: 100%;
        }
        #price-range-table tr {
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 0.75rem;
        }
        #price-range-table td {
            text-align: right;
            padding-left: 50%;
            position: relative;
            border: none;
            border-bottom: 1px solid #dee2e6;
        }
        #price-range-table td:last-child {
            border-bottom: 0;
        }
        #price-range-table td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            top: 0.75rem;
            font-weight: 600;
            text-align: left;
            color: #212529;
            white-space: nowrap;
        }
        /* Button full width on mobile */
        .remove-range {
            width: 100%;
            margin-top: 0.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let rangeIndex = {{ count($priceRanges) }};

    document.getElementById('add-range').addEventListener('click', function () {
        const table = document.querySelector('#price-range-table tbody');

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td data-label="De (jours)"><input type="text" name="price_ranges[${rangeIndex}][min_days]" class="form-control" required></td>
            <td data-label="À (jours)"><input type="text" name="price_ranges[${rangeIndex}][max_days]" class="form-control" required></td>
            <td data-label="Prix (€)"><input type="text" name="price_ranges[${rangeIndex}][price]" class="form-control" required></td>
            <td data-label="Action"><button type="button" class="btn btn-danger btn-sm remove-range">Supprimer</button></td>
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
