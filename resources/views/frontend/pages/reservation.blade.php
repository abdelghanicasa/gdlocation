@extends('frontend.layouts.app')

@section('content')

<!-- Start About Section -->
<section>
    <div class="container">
        <!-- Display validation errors -->
        @if(session('error'))
        <div class="alert alert-danger">
            {!! session('error') !!}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div style="padding:25px 0px 25px 0%;">
            <h2 class="cs_fs_38 mb-0 wow text-uppercase fw-lighter">
                Votre Réservation
            </h2>
            <p>Quelques étapes et vous êtes prêt pour l’aventure...</p>
        </div>
    </div>
</section>

<section>
    <div class="cs_slider cs_style_1 cs_slider_gap_60 cs_hover_show_arrows">
        <div class="container">
            <div class="cs_slider_container" data-autoplay="0" data-loop="1" data-speed="600" data-center="0"
                data-variable-width="0" data-slides-per-view="responsive" data-xs-slides="1" data-sm-slides="2"
                data-md-slides="2" data-lg-slides="3" data-add-slides="2">
                <div class="cs_slider_wrapper">
                    <!-- START -->
                    <!-- Début de la section Scooters -->
                    @foreach($scooterss as $scooter)
                    <div class="cs_slides" id="SelectedScooter">
                        <div class="cs_post cs_style_1 p-3 cs_radius_10 SelectedScooter" style="background-color: #E5DFDC;" data-scooter-id="{{ $scooter->id }}">
                            <span href="#" class="cs_radius_5 overflow-hidden d-block cs_mb_lg_20 position-relative">
                                <img src="{{ asset('storage/' . $scooter->photo) }}" alt="{{ $scooter->modele }}"
                                    style="padding: 20px; width: 500px; object-fit: contain; margin-top: 13px; display: block; margin-left: auto; margin-right: auto;">
                                <div class="cs_hover_icon cs_center position-absolute cs_black_color cs_zindex_2 cs_radius_5">
                                    <h4 style="color: black;">{{ $scooter->marque }} {{ $scooter->modele }}</h4>
                                    <!-- Container positionné -->
                                    <div style="position: relative;">
                                        <!-- Prix dynamique -->
                                        <div>
                                            <span class="text-dark cs_price cs_fs_21">
                                                <span id="totalDuJour">{{ number_format($scooter->current_price) }}</span> 
                                                <small style="font-size: 13px;">€/Jour</small>
                                            </span>
                                        </div>
                                        <!-- Texte à droite -->
                                    </div>
                                </div>

                            </span>
                            <!-- Checked icon -->
                            <div id="checked-icon-{{ $scooter->id }}" class="checked-icon position-absolute" style="top: 10px; right: 10px; display: none;">
                                <i class="fas fa-check-circle" style="color: #28a745; font-size: 24px;"></i>
                            </div>
                            <!-- Bouton de réservation -->
                            <div class="d-flex justify-content-center">
                                <button onclick="selectScooter('{{ $scooter->id }}', '{{ $scooter->marque }} {{ $scooter->modele }}', '{{ $scooter->current_price }}')"
                                    class="cs_btn text-uppercase w-100 cs_style_2 cs_medium cs_radius_5 cs_fs_15">
                                    Sélectionner
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- END -->

                </div>
            </div>
        </div>
        <div class="cs_pagination cs_style_1 cs_mobile_show"></div>
    </div>
    <div class="cs_height_50 cs_height_lg_80"></div>
</section>



<!-- Start Sccoters Reservation Section -->
<section>
    <div class="container py-4">
        <div class="row">
            <!-- Left Side (Form & Information) -->
            <div class="col-md-9 order-2 order-md-1">
                <!-- Personal Information -->
                <div class="card bg-secondary p-0 mb-4">
                    <div class="card-header cs_color_yellow text-dark fw-bold">
                        Informations personnelles
                    </div>
                    <div class="card-body cs_color_brown">
                        <form action="{{ route('reservation.create') }}" method="POST">
                        @csrf
                            @php
                            $StartdateHeure = $startDate->format('d/m/Y H\Hi'); // Format: 21/04/2025 14H30
                            $Startdate = $startDate->format('d/m/Y'); // Format: 21/04/2025
                            $Startheure = $startDate->format('H\Hi'); // Format: 14H30

                            $EnddateHeure = $endDate->format('d/m/Y H\Hi'); // Format: 21/04/2025 14H30
                            $Enddate = $endDate->format('d/m/Y'); // Format: 21/04/2025
                            $Endheure = $endDate->format('H\Hi'); // Format: 14H30

                            @endphp
                            
                            <input type="hidden" name="start_time" id="start_time" value="{{ $Startheure }}">
                            <input type="hidden" name="end_time" id="end_time" value="{{ $Endheure }}">

                            <input type="hidden" name="start" id="start" value="{{ $Startdate }}">
                            <input type="hidden" name="end" id="end" value="{{ $Enddate }}">
                            <input type="hidden" name="age_conducteur" id="age_conducteur" value="{{ $driverAge }}">
                            <input type="hidden" name="scooter_id" id="scooter_id" value="">
                            <input type="hidden" name="nombre_jours" id="nombre_jours" value="">
                            <input type="hidden" name="montant" id="montant" value="">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Nom" name="nom" value="" {{ old('nom') }} required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Prénom" name="prenom" value="" {{ old('prenom') }} required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Adresse" name="adresse" value="" {{ old('adresse') }}>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Code postal" name="code_postal" value="" {{ old('code_postal') }}>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Ville" name="ville" value="" {{ old('ville') }}>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Pays" name="pays" value="" {{ old('pays') }}>
                                </div>
                                <div class="col-md-6">
                                    <input type="phone" class="form-control" placeholder="Téléphone" name="tel" value="" {{ old('tel') }} required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Email" name="email" value="" {{ old('email') }} required>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="Nom de la société (Facultatif)" name="nom_societe" value="" {{ old('nom_societe') }}>
                                </div>

                                <input type="hidden" name="discountValue" id="discountValue" value="0">
                            </div>
                        
                    </div>
                </div>

                <!-- Rental Information -->
                <div class="card bg-secondary p-0 rentalDesktop">
                    <div class="card-header cs_color_yellow text-dark fw-bold">
                        Information Sur Le Loueur
                    </div>
                    <div class="card-body cs_color_brown">
                        <div class="row">
                            <div class="col-md-6">
                                <strong class=" text-yellow">Localisation</strong>
                                <p class="text-light">{!! $company->address !!}</p>
                            </div>
                            <div class="col-md-6 rounded p-2">
                                <strong class=" text-yellow">Horaire D'ouverture De La Boutique</strong>
                                <p class="text-white"><strong>{{ $company->saison }}</strong></p>
                                <table class="text-light">
                                    <tbody>
                                        @php
                                        $days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
                                        $hours = explode("\n", $company->horaires); // Split horaires by line
                                        @endphp
                                        @foreach($days as $index => $day)
                                        <tr>
                                            <td>{{ $day }}</td>
                                            <td>{{ $hours[$index] ?? 'Fermé' }}</td> <!-- Default to 'Fermé' if no value -->
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div style="height: 15px;"></div>

                        <strong class="text-yellow">Modification/Annulation</strong>
                        <span class="text-light">
                            <br>{!! $company->note ?? '' !!}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Side (Order Summary) -->
            <div class="col-md-3 order-2 order-md-2" style="margin-bottom:20px;">
                <div class="card bg-secondary p-0">
                    <div class="card-header cs_color_brown text-light fw-bold"> Panier</div>

                    <div class="card-body cs_color_brownDark" >
                        <h6 class="fw-bold">Vos dates</h6>
                        <!-- Departure & Return Dates -->
                        <div class="row g-2 mt-2 rounded" style="background-color: #E5DFDC;">
                            <div class="col-12">
                                <div class=" text-dark rounded p-2 d-flex justify-content-between">
                                    <span>Départ le :</span>
                                    <span>
                                        <strong>{{ $startDate->format('d/m/Y H\Hi') }}</strong></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-dark rounded p-2 d-flex justify-content-between">
                                    <span>Retour le :</span> <strong>{{ $endDate->format('d/m/Y H\Hi') }}</strong>
                                </div>
                            </div>
                        </div>

                        <p class="mt-3 text-white text-center fs-5">
                            <span>Soit {{ ceil($duration) }} Jour(s) de location</span>
                        </p>
                        <hr>

                        <!-- Service Included -->
                        <div class="row g-2 mt-0 rounded p-0">
                            <div class="col-12">
                                <div class="text-right text-white d-flex justify-content-between">
                                    <div class="text-left fs-5">Services GD LOC</div>
                                    <div class="fw-bold">Offerts</div>
                                </div>
                                <div class="" style="color: #E5DFDC">Top case, casques, gants et antivol </div>
                            </div>
                        </div>

                        <!-- Service Included -->
                        <div class="row g-2 mt-0 rounded p-0">
                            <div class="col-12">
                                <div class="text-left text-white d-flex justify-content-between">
                                    <!-- <div class="text-center fs-8"> :</div> -->

                                </div>
                            </div>
                        </div>

                        <!-- Vehicle & Number of Persons -->
                        <div class="row g-2 mt-2 rounded p-3 mb-4" style="background-color: #E5DFDC;">
                            <div class="col-12">
                                <div class="text-center text-white d-flex justify-content-between">
                                    <div class="text-center text-dark">Scooter </div>
                                    <div class="fw-bold text-dark" id="selected-scooter-name">-</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-center text-white d-flex justify-content-between">
                                    <div class="text-dark">Age du conducteur </div>
                                    <div class="fw-bold text-dark"> {{ $driverAge }}</div>
                                </div>
                            </div>
                        </div>

                            <!-- Discount Section -->
                            <div class="row g-2 mt-3 p-0 mb-4">
                            <div class="col-12">
                                <div class="input-group">
                                    <input type="text" 
                                        class="form-control" 
                                        placeholder="Code promo" 
                                        id="discountCode"
                                        style="background-color: #E5DFDC; border-color: #F7CA84;">
                                    <button class="btn" 
                                            type="button"
                                            id="applyDiscount"
                                            style="background-color: #F7CA84; color: #000; border-color: #F7CA84;">
                                        Appliquer
                                    </button>
                                </div>
                            </div>
                        </div> 
                        <!-- Discount Display (hidden by default) -->
                        <div class="row g-2 mt-2" id="discountDisplay" style="display: none; mb-2">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-white">Réduction appliquée:</span>
                                    <span class="fw-bold text-success" id="discountAmount"></span>
                                    <input type="hidden" id="montantPromo">
                                </div>
                            </div>
                        </div>

                        <div style="height:10px;"></div>
                        
                        <button type="submit"
                                class="btn btn-dark w-100 py-2 fw-bold fs-3 text-dark"
                                style="background-color: #F7CA84;" id="paymentButton" disabled>
                            PAYER 00 €
                        </button>
                    </form>
                    </div>
                </div>

                <div class="card bg-secondary p-0 rentalMobile" style="margin-top: 20px;">
                    <div class="card-header cs_color_yellow text-dark fw-bold">
                        Information Sur Le Loueur
                    </div>
                    <div class="card-body cs_color_brown">
                        <div class="row">
                            <div class="col-md-6">
                                <strong class=" text-yellow">Localisation</strong>
                                <p class="text-light">{!! $company->address !!}</p>
                            </div>
                            <div class="col-md-6 rounded p-2">
                                <strong class=" text-yellow">Horaire D'ouverture De La Boutique</strong>
                                <p class="text-white"><strong>{{ $company->saison }}</strong></p>
                                <table class="text-light">
                                    <tbody>
                                        @php
                                        $days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
                                        $hours = explode("\n", $company->horaires); // Split horaires by line
                                        @endphp
                                        @foreach($days as $index => $day)
                                        <tr>
                                            <td>{{ $day }}</td>
                                            <td>{{ $hours[$index] ?? 'Fermé' }}</td> <!-- Default to 'Fermé' if no value -->
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div style="height: 15px;"></div>

                        <strong class="text-yellow">Modification/Annulation</strong>
                        <span class="text-light">
                            <br>{!! $company->note ?? '' !!}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Rental Information Mobile-->

        </div>
    </div>

    <div class="cs_height_50 cs_height_lg_80"></div>
</section>

<style>
/* ===== VERSION DESKTOP ===== */
@media (min-width: 768px) {
    .rentalMobile{
        display: none;
    }
}

/* ===== VERSION MOBILE ===== */
@media (max-width: 767px) {
    .rentalDesktop{
        display: none;
    }
    .rentalMobile{
        display: block;
    }
}

    .slick-prev {
        display: none !important
    }

    .slick-next {
        display: none !important
    }

    #discountCode {
        height: 45px !important;
        border-radius: 4px 0 0 4px !important;
    }


    #applyDiscount {
        height: 45px !important;
        border-radius: 0 4px 4px 0 !important;
        transition: all 0.3s ease;
    }

    #applyDiscount:hover {
        background-color: #e0b875 !important;
    }


    #discountDisplay {
        background-color: rgba(247, 202, 132, 0.2);
        padding: 8px;
        border-radius: 4px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const applyBtn = document.getElementById('applyDiscount');
        const discountInput = document.getElementById('discountCode');
        const discountDisplay = document.getElementById('discountDisplay');
        const discountAmount = document.getElementById('discountAmount');
        const finalTotal = document.getElementById('finalTotal');
        
        applyBtn.addEventListener('click', function() {
            const code = discountInput.value.trim();
            const total = parseFloat(document.getElementById('montant').value || 0);

            fetch("{{ route('promo.verify') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message || 'Code invalide.');
                    return;
                }

                let discount = 0;
                if (data.type === 'percent') {
                    discount = total * (data.discount / 100);
                } else {
                    discount = data.discount;
                }

                const newTotal = Math.max(0, total - discount);
                discountAmount.textContent = `-${discount.toFixed(2)} €`;
                discountDisplay.style.display = 'block';

                document.querySelector('.fw-bold.fs-3').textContent = newTotal.toFixed(2) + ' €';
                document.getElementById('paymentButton').textContent = `PAYER ${newTotal.toFixed(2)} €`;

                document.getElementById('discountValue').value = discount.toFixed(2);
                document.getElementById('montant').value = newTotal.toFixed(2);
            })
            .catch(() => {
                alert("Une erreur s’est produite lors de la vérification du code.");
            });
        });


    });

    document.addEventListener('DOMContentLoaded', function() {
        window.scroll(0, 700);
        window.scroll(options);
        const paymentButton = document.getElementById('paymentButton');
        messageElement.style.display = 'block'; // Affiche le message au chargement
        paymentButton.disabled = true;
        paymentButton.style.opacity = '0.5';
        paymentButton.style.cursor = 'not-allowed';
        messageElement.style.display = 'block'; // Affiche le message au chargement

    });

    function selectScooter(scooterId, scooterName, scooterPrice) {
        // Afficher dans la console
        console.log('Scooter sélectionné:', {
            id: scooterId,
            nom: scooterName,
            prix: scooterPrice
        });

        // 1. Réinitialiser toutes les couleurs
        document.querySelectorAll('.SelectedScooter').forEach(scooter => {
            scooter.style.backgroundColor = '#E5DFDC'; // Couleur par défaut
        });

        // 2. Trouver et mettre en surbrillance le scooter sélectionné
        const selectedScooterElement = document.querySelector(`.SelectedScooter[data-scooter-id="${scooterId}"]`);
        if (selectedScooterElement) {
            selectedScooterElement.style.backgroundColor = '#F7CA84'; // Couleur de sélection

        }

        // Mettre à jour le résumé de commande
        document.getElementById('selected-scooter-name').textContent = scooterName;

        // Update the hidden input field with the selected scooter ID
        document.getElementById('scooter_id').value = scooterId;

        const startDate = new Date('{{ $startDate->toIso8601String() }}'); // ajoute le Z
        const endDate = new Date('{{ $endDate->toIso8601String() }}');

    
        console.log(startDate);
        console.log(endDate);

        // Calcul correct du nombre de jours réels
        const startUTC = Date.UTC(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
        const endUTC = Date.UTC(endDate.getFullYear(), endDate.getMonth(), endDate.getDate());
        let days = Math.floor((endUTC - startUTC) / (1000 * 60 * 60 * 24));

        // Minimum 1 jour garanti si même jour mais heures différentes
        if (days === 0) {
            const startTime = startDate.getHours() * 60 + startDate.getMinutes();
            const endTime = endDate.getHours() * 60 + endDate.getMinutes();
            if (endTime > startTime) {
                days = 1;
            }
        }

        // Mettre à jour le nombre de jours
        document.getElementById('nombre_jours').value = days;
        console.log(days);
        // Calculer le prix total
        // const totalPrice = scooterPrice * days;
        fetch('{{ route('scooter.price') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                scooter_id: scooterId,
                days: days,
                start_date: startDate.toISOString(), // "2025-09-01" .split('T')[0]
                end_date: endDate.toISOString()     // "2025-09-04"  .split('T')[0] 
            })
        })
        .then(response => response.json())
        .then(data => {
            // const realPrice = parseFloat(data.price);
            const realPrice = parseFloat(String(data.price).replace(',', '.').replace(/\s/g, ''));

            const totalPrice = realPrice;

            document.querySelector('.fw-bold.fs-3').textContent = totalPrice.toFixed(0) + ' €';
            document.getElementById('montant').value = totalPrice.toFixed(0);
            document.getElementById('paymentButton').textContent = `PAYER ${totalPrice.toFixed(0)} €`;

            paymentButton.disabled = false;
            paymentButton.style.opacity = '1';
            paymentButton.style.cursor = 'pointer';

            // Stocker avec le vrai prix
            sessionStorage.setItem('selectedScooter', JSON.stringify({
                id: scooterId,
                name: scooterName,
                price: realPrice,
                days: days,
                total: totalPrice
            }));
            // document.getElementById('totalDuJour').value = realPrice;
            console.log(realPrice);
        })
        .catch(() => {
            alert("Erreur lors du calcul du prix.");
        });

        window.scroll(0, 1200);

        // Afficher un message de confirmation
        Swal.fire({
            icon: 'success',
            title: 'Scooter sélectionné!',
            text: `Vous avez choisi ${scooterName} pour ${days} jours`,
            confirmButtonColor: '#F2C885'
        });

        // Change the background color of the selected scooter
        const allScooters = document.querySelectorAll('.SelectedScooter');
        allScooters.forEach(scooter => {
            scooter.style.backgroundColor = '#E5DFDC'; // Reset to default color
        });

        const selectedScooter = document.querySelector(`#checked-icon-${scooterId}`).closest('.SelectedScooter');
        if (selectedScooter) {
            selectedScooter.style.backgroundColor = '#F7CA84'; // Highlight selected scooter
        }

        // Show the checked icon for the selected scooter
        const allIcons = document.querySelectorAll('.checked-icon');
        allIcons.forEach(icon => icon.style.display = 'none'); // Hide all icons
    }
    
    // document.getElementById('paymentButton').addEventListener('click', function() {
    //     const selectedScooter = JSON.parse(sessionStorage.getItem('selectedScooter'));

    //     if (!selectedScooter || selectedScooter.total <= 0) {
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'Sélection requise',
    //             text: 'Veuillez sélectionner un scooter avant de payer',
    //             confirmButtonColor: '#F2C885'
    //         });
    //         return;
    //     }

    //     // Soumission du formulaire
    //     document.querySelector('form[action="{{-- route('reservation.create') --}}"]').submit();
    // });
</script>
@endsection