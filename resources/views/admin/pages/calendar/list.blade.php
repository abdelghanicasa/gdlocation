@extends('admin.app')

@section('content')
<div class="col-sm-12">
    <!-- Filtre amélioré avec indication de la période active -->
    @if(request('date_filter') || request('today'))
    <div class="alert alert-dark text-dark mb-3">
        Affichage des réservations pour :
        <strong>
            @if(request('today'))
            aujourd'hui ({{ now()->format('d/m/Y') }})
            @else
            {{ \Carbon\Carbon::parse(request('date_filter'))->format('d/m/Y') }}
            @endif
        </strong>
    </div>
    @endif

    <div class="mb-4 card iq-card my-auto">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.calendar.list') }}" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label for="date_filter" class="form-label">Filtrer par date</label>
                    <input type="date" class="form-control" id="date_filter" name="date_filter" placeholder="recherche"
                        value="../../....">
                </div>

                <div class="col-md-8 d-flex flex-wrap align-items-start gap-2 mt-4" style="font-size: 0.85rem;">

                    <button type="submit" class="btn btn-light btn-filter px-2 py-1" style="font-size: 0.85rem;">
                        <i class="fa fa-filter"></i> Appliquer
                    </button>

                    <a href="{{ route('admin.calendar.list') }}" class="btn btn-light btn-filter px-2 py-1" style="font-size: 0.85rem;">
                        <i class="fa fa-times"></i> Réinitialiser
                    </a>

                    <!-- Option de période -->
                    <div class="d-flex flex-column flex-md-row align-items-start gap-2">
                        <!-- <label class="fw-bold mb-2 mb-md-0" style="font-size: 0.85rem;">Filtres par :</label> -->
                        <div class="btn-group flex-wrap" role="group">
                            <a href="{{ route('admin.calendar.list', ['today' => true]) }}"
                                class="btn btn-light btn-filter px-2 py-1 {{ request()->has('today') ? 'active' : '' }}"
                                style="font-size: 0.85rem;">
                                <i class="fa fa-calendar-day"></i> Aujourd'hui
                            </a>

                            <a href="{{ route('admin.calendar.list', ['period' => 'week']) }}"
                                class="btn btn-light btn-filter px-2 py-1 {{ request('period') == 'week' ? 'active' : '' }}"
                                style="font-size: 0.85rem;">
                                Cette semaine
                            </a>

                            <a href="{{ route('admin.calendar.list', ['period' => 'month']) }}"
                                class="btn btn-light btn-filter px-2 py-1 {{ request('period') == 'month' ? 'active' : '' }}"
                                style="font-size: 0.85rem;">
                                Ce mois
                            </a>
                        </div>
                    </div>
                        
                </div>


            </form>
        </div>
    </div>

    <div class="iq-card">
        <div class="iq-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">

            <div class="iq-header-title">
                <h4 class="card-title text-light mb-0">Liste des réservations</h4>
            </div>

            @include('admin.message.alert')

            <div class="btn-group" role="group">
                <a href="{{ route('admin.calendar.export', ['format' => 'csv']) }}"
                    class="btn btn-outline-dark btn-sm export-btn px-2 py-1" style="font-size: 0.85rem;">
                    <i class="fa fa-file-csv me-1"></i> CSV
                </a>

                <a href="{{ route('admin.calendar.export', ['format' => 'pdf']) }}"
                    class="btn btn-outline-danger btn-sm export-btn px-2 py-1" style="font-size: 0.85rem;">
                    <i class="fa fa-file-pdf me-1"></i> PDF
                </a>
            </div>

        </div>

        <div class="iq-card-body">
            <div class="table-responsive">
                <table id="listResa" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Scooter</th>
                            <th scope="col">Dates</th>
                            <th scope="col">Heures</th>
                            <th scope="col">Montant</th>
                            <th scope="col">Paiement</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $reservation)
                        <tr>
                            <td scope="row">{{ $reservation->id }}</td>
                            <td>{{ optional($reservation->client)->nom ?? '---' }}
                            </td>
                            <td>
                                <i class="fa fa-circle" style="font-size:6px; color:{{  $reservation->color }}"></i> {{ $reservation->scooter->modele ?? '----'}}
                            </td>
                            <td>
                                <div>
                                    {{ date('d/m/Y', strtotime($reservation->start)) }} au {{ date('d/m/Y', strtotime($reservation->end)) }}
                                </div>
                            </td>
                            <td>
                                <div>{{ substr($reservation->start_time, 0, 5) }} / {{ substr($reservation->end_time, 0, 5) }}</div>
                            </td>
                            <td>{{ $reservation->montant }} €</td>
                            <td>
                                <span class="badge bg-{{ $reservation->etat_paiement === 'confirmé' ? 'success' : 'danger' }}">
                                    {{ $reservation->etat_paiement === 'confirmé' ? 'Payé' : 'Impayé' }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="d-flex">
                                    <a href="{{ route('admin.calendar.show', $reservation->id) }}" class="btn btn-sm btn-light me-1" title="Voir">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.calendar.generate', $reservation->id) }}"
                                        class="btn btn-sm btn-light  me-1"
                                        target="_blank">
                                        <i class="fa fa-file-pdf me-1"></i>
                                    </a>
                                    <a href="{{ route('admin.calendar.edit', $reservation->id) }}"
                                        class="btn btn-sm btn-light  me-1"
                                        target="">
                                        <i class="fa fa-edit me-1"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $reservation->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <form id="delete-form-{{ $reservation->id }}" action="{{ route('calendar.destroyinList', $reservation->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td class="text-center">Aucune réservation trouvée</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Loader -->
<div id="export-loader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.7); z-index: 9999;">
    <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
        <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
            <span class="visually-hidden">Chargement...</span>
        </div>
    </div>
</div>


@push('styles')

<style>
    .paginationss p {
        display: none;
    }

    .btn-filter {
        transition: all 0.3s ease;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .badge {
        font-size: 0.85em;
        font-weight: 500;
        padding: 0.35em 0.65em;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    document.querySelectorAll('.export-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            // e.prrese$reservationDefault(); // Empêche la navigation immédiate
            e.preventDefault();

            const exportUrl = this.href;

            // Affiche le loader avec SweetAlert
            Swal.fire({
                title: 'Export en cours...',
                text: 'Génération du fichier, veuillez patienter...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading(); // Affichage du loader
                }
            });

            // Lance le téléchargement après un délai de 700ms
            setTimeout(() => {
                window.location.href = exportUrl; // Redirection vers l'URL d'export
                setTimeout(() => Swal.close(), 3500); // Ferme le loader après 5s
            }, 700); // Délai avant de rediriger
        });
    });

    function updateReservationEtat(id, etat) {
        Swal.fire({
            title: 'Es-tu sûr ?',
            text: `Tu vas ${etat} cette réservation.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui',
            cancelButtonText: 'Annuler',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`{{ url('/panel/reservations') }}/${id}/etat`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            etat: etat
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire('Succès', data.message, 'success');
                        setTimeout(() => location.reload(), 1000); // Recharge les données
                    })
                    .catch(() => Swal.fire('Erreur', 'Une erreur est survenue.', 'error'));
            }
        });
    }

    document.querySelectorAll('.btn-confirm').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            updateReservationEtat(id, 'payé');
        });
    });

    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            updateReservationEtat(id, 'annulé');
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Supprimer ?',
            text: "Cette action est irréversible.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

@endpush


@endsection