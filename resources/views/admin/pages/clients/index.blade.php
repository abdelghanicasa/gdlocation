@extends('admin.app')

@section('content')
<div class="col-sm-12">
    <div class="mb-4 card iq-card">
        <div class="card-body">
            <form method="GET" action="{{ route('clients.index') }}" class="row g-3 align-items-center">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher par nom, email, téléphone" value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-light">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                    <a href="{{ route('clients.index') }}" class="btn btn-light me-2 btn-filter">
                        <i class="fa fa-times"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="mb-2">
        <strong>{{ $clients->total() }}</strong> client(s) trouvé(s)
    </div>
    @if(request()->has('search') && request()->get('search') !== '')
        <div class="alert alert-info">
            {{ $clients->total() }} client(s) trouvé(s) pour la recherche : <strong>"{{ request()->get('search') }}"</strong>
        </div>
    @endif
  
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title text-light">Liste des clients</h4>
            <!-- <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddClient">
                <i class="fas fa-plus"></i> Ajouter un client
            </a> -->

            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modalAddClient">
               <i class="fa fa-plus"></i>  Ajouter un client
            </button>
        </div>
        <div class="iq-card-body">
            <div class="table-responsive">
                <table id="listResa" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Nbr de Reservations</th> 
                            <th>Email</th>
                            <th>Téléphone</th>
                            <!-- <th>Adresse</th> -->
                            <!-- <th>Ville</th> -->
                            <!-- <th>Code Postal</th> -->
                            
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $client->nom }}</td>
                            <td>{{ $client->prenom }}</td>
                            <td>{{ $client->reservations_count }} </td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->tel }}</td>
                            <!-- <td>{{ $client->adresse }}</td>
                            <td>{{ $client->ville }}</td>
                            <td>{{ $client->code_postal }}</td> -->
                            <td class="text-center">

                                <div class="d-flex">
                                    <a href="{{ route('clients.show', $client->id) }}" class="btn btn-sm btn-light">
                                    <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-light">
                                    <i class="fa fa-edit"></i>
                                    </a>
                                    <form id="delete-form-{{ $client->id }}" action="{{ route('clients.destroy', $client->id) }}"
                                    method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $client->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-dark">
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Reservations</th> NEW
                        <th>Email</th>
                        <th>Téléphone</th>
                        <!-- <th>Adresse</th>
                        <th>Ville</th>
                        <th>Code Postal</th> -->
                        <th class="text-center">Actions</th>
                    </tfoot>
                </table>
            </div>

            <!-- Pagination -->
            <!-- <div class="d-flex justify-content-center mt-3">
                {{ $clients->links() }}
            </div> -->
        </div>
    </div>
</div>

<!-- Modal -->
 <!-- Modal Ajouter Client -->
<div class="modal fade" id="modalAddClient" tabindex="-1" aria-labelledby="modalAddClientLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="background-color:#1a1d20;" >
      <form method="POST" action="{{ route('clients.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddClientLabel">Ajouter un client.</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nom</label>
              <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Prénom</label>
              <input type="text" name="prenom" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Téléphone</label>
              <input type="text" name="tel" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label class="form-label">Adresse</label>
              <input type="text" name="adresse" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Ville</label>
              <input type="text" name="ville" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Code postal</label>
              <input type="text" name="code_postal" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a href="/panel/clients" class="btn btn-light">Annuler</a>

            <button type="submit" class="btn btn-secondary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    function closeModal() {
        // alert('hello');
        var modal = document.getElementById('modalAddClient');
        modal.style.display = 'none'; // Cacher le modal
    }

    function confirmDelete(clientId) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + clientId).submit();
            }
        });
    }
</script>
@endsection