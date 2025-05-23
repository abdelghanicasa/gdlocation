@extends('admin.app') {{-- Remplace "admin.layouts.app" par le chemin exact de ton fichier de layout --}}

@section('content')

<div class="row">


   <div class="col-sm-6 col-md-6 col-lg-4">
      <div class="iq-card iq-card-block iq-card-stretch iq-card-height" style="background-color: #717179;">
         <div class="iq-card-body iq-box-relative">
            <div class="d-flex align-items-center justify-content-between text-right">
               <div class="icon iq-icon-box rounded-circle ">
                  <!-- <i class="fa fa-handshake-o" aria-hidden="true"></i> -->
               </div>
               <div>
                  <!-- CA du mois -->
                  <h5 class="mb-0 text-dark">Chiffre d'affaire du mois</h5>
                  <span class="h4 mb-0 d-inline-block w-100" style="color: black;">{{ $totalConfirmée }} €</span>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="col-sm-6 col-md-6 col-lg-4">
      <div class="iq-card iq-card-block iq-card-stretch iq-card-height" style="background-color: #717179;">
         <div class="iq-card-body iq-box-relative">
            <div class="d-flex align-items-center justify-content-between text-right">
               <div class="icon iq-icon-box rounded-circle ">
                  <!-- <i class="ri-building-line" aria-hidden="true"></i> -->
               </div>
               <div>
                  <!-- CA total -->
                  <h5 class="mb-0 text-dark">Réservations en cours</h5>
                  <span class="h4 mb-0 d-inline-block w-100" style="color: black;">{{ $totalEnCours }} €</span>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="col-sm-6 col-md-6 col-lg-4">
      <div class="iq-card iq-card-block iq-card-stretch iq-card-height" style="background-color: #717179;">
         <div class="iq-card-body iq-box-relative">
            <div class="d-flex align-items-center justify-content-between text-right">
               <div class="icon iq-icon-box rounded-circle ">
                  <!-- <i class="ri-building-line" aria-hidden="true"></i> -->
               </div>
               <div>
                  <!-- CA total -->
                  <h5 class="mb-0 text-dark">Scooters disponibles </h5>
                  <span class="h4 mb-0 d-inline-block w-100" style="color: black;">{{ $nbrScootersDisponibles }} Scooter(s)</span>
               </div>
            </div>
         </div>
      </div>
   </div>


   <div class="col-lg-12">
      <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
         <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
            <h4 class="card-title text-light">Etat des commandes </h4>
            </div>
         </div>
         <div class="iq-card-body">
            <div class="table-responsive">
               <table class="table mb-0 table-borderless">
                  <thead>
                     <tr>
                        <th scope="col">Commande No</th>
                        <th scope="col">Clients</th>
                        <th scope="col">Scooter</th>
                        <th scope="col">Montant</th>
                        <th scope="col">Date de départ</th>
                        <th scope="col">Date de retour</th>
                        <th scope="col">Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($reservations as $reservation)
                        <tr>
                              <td>
                                 <a href="{{ route('admin.calendar.show', $reservation->id) }}" class="btn btn-sm btn-light me-1" title="Voir">
                                    <i class="fa fa-eye"></i> {{ $reservation->reference }}
                                 </a>
                              </td>
                              <td>
                                
                                 {{ $reservation->client->nom ?? $reservation->tel }}
                                 
                              </td>
                              <td>
                                 {{ $reservation->scooter->caracteristiques ?? 'N/A' }}
                              </td>
                              <td>
                                 <p class="mb-2">{{ $reservation->montant }} €</p>
                                 <!-- <div class="iq-progress-bar">
                                    <span class="bg-{{-- $reservation->etat_reservation == 'confirmée' ? 'success' : 'danger' --}}" data-percent="{{ $reservation->nombre_jours * 10 }}" style="transition: width 2s;"></span>
                                 </div> -->
                              </td>
                              <td>{{ \Carbon\Carbon::parse($reservation->start)->format('d/m/Y') }} à {{ substr($reservation->start_time, 0, 5) }}</td>
                              <td>{{ \Carbon\Carbon::parse($reservation->end)->format('d/m/Y') }} à {{ substr($reservation->end_time,0,5) }}</td>
                              <td>
                                 <div class="badge badge-pill badge-{{ $reservation->etat_reservation == 'confirmée' ? 'success' : 'warning' }}">
                                    {{ ucfirst($reservation->etat_reservation) }}
                                 </div>
                              </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>

</div>
@push('style')
<style>

</style>
@endpush
@endsection