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

        <div style="padding:2px 0px 2px 0%;">
            <h2 class="cs_fs_38 mb-0 wow text-uppercase fw-lighter">
            Contact
            </h2>
            <p>Vous avez une question ? Envoyez-nous un message !</p>
        </div>
    </div>
</section>



<!-- Start Sccoters Reservation Section -->
<section>
    <div class="container py-4">
        <div class="row">
            <!-- Left Side (Form & Information) -->
            <div class="col-md-8">

                @if(session('success'))
                   <div class="alert alert-success">
                    {{ session('success') }}
                   </div>
                @endif

                <!-- Form Information -->
                <div class="card bg-secondary p-0">
                    <div class="card-body cs_color_brown">
                        <div style="height: 15px;"></div>
                        <!-- Formulaire de contact -->
                        <div class="contact-form">
                            <h5 class="fw-bold text-yellow mb-4">Nous contacter</h5>
                            <form action="{{ route('contact.submit') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <!-- Colonne gauche -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nom" class="form-label text-light">Nom *</label>
                                            <input type="text" class="form-control bg-dark text-light border-dark" id="nom" name="nom" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label text-light">Email *</label>
                                            <input type="email" class="form-control bg-dark text-light border-dark" id="email" name="email" required>
                                        </div>
                                    </div>

                                    <!-- Colonne droite -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="prenom" class="form-label text-light">Prénom *</label>
                                            <input type="text" class="form-control bg-dark text-light border-dark" id="prenom" name="prenom" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="telephone" class="form-label text-light">Téléphone *</label>
                                            <input type="tel" class="form-control bg-dark text-light border-dark" id="telephone" name="telephone" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sujet (pleine largeur) -->
                                <div class="mb-3">
                                    <label class="form-label text-light">Je vous contacte pour *</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="" type="radio" name="sujet" id="location" value="Location" checked>
                                            <label class="form-check-label text-light" for="location">Location</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="" type="radio" name="sujet" id="annulation" value="Annulation">
                                            <label class="form-check-label text-light" for="annulation">Annulation</label>
                                        </div>
                                        
                                    </div>
                                </div>

                                <!-- Message (pleine largeur) -->
                                <div class="mb-3">
                                    <label for="message" class="form-label text-light">Message</label>
                                    <textarea class="form-control bg-dark text-light border-dark" id="message" name="message" rows="3"></textarea>
                                </div>

                                <button type="submit" class="btn cs_color_yellow text-dark fw-bold">Envoyer le message</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="spacer">
                <div class="cs_height_50 cs_height_lg_50"></div>
            </div>

            <!-- Right Side (Order Summary) -->
            <div class="col-md-4">
                <div class="card bg-secondary p-0">
                    <div class="card-header cs_color_yellow  text-dark fw-bold"> Informations sur le Loueur</div>

                    <div class="card-body cs_color_brown">
                        <div class="row">
                            <div class="">
                                <strong class="text-yellow">Localisation</strong>
                                <p class="text-light">{!! $company->address !!}</p>
                                <strong class="text-yellow">Horaire D'ouverture De La Boutique</strong>
                                <p class="text-white"><span>{{ $company->saison }}</span></p>
                                <table class="text-light">
                                    <tbody>
                                        @php
                                        $days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
                                        $hours = explode("\n", $company->horaires); // Split horaires by line
                                        @endphp
                                        @foreach($days as $index => $day)
                                        <tr style="border-color: #57483e; border-style: solid; border-width: 1px; !important;">
                                            <td>{{ $day }}</td>
                                            <td>{{ $hours[$index] ?? 'Fermé' }}</td> <!-- Default to 'Fermé' if no value -->
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 rounded p-2">

                            </div>
                        </div>
                        <!-- <hr> -->
                        <div style="height: 15px;"></div>

                        <!-- <strong class="text-yellow">Modification/Annulation</strong>
                        <span class="text-light">
                            <br>{!! $company->note ?? '' !!}
                        </span> -->
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
<!-- End Features Section -->
<script>
    // Initialisation - Désactive le bouton PAYER au chargement
    document.addEventListener('DOMContentLoaded', function() {
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

        // Mettre à jour le résumé de commande
        document.getElementById('selected-scooter-name').textContent = scooterName;

        // Update the hidden input field with the selected scooter ID
        document.getElementById('scooter_id').value = scooterId;

        // Calculate the duration and update the hidden input field
        const daysElement = document.querySelector('p.fs-5 strong');
        let days = 1; // Default value

        // Extract the number of days from the text if available
        if (daysElement) {
            const daysText = daysElement.textContent.match(/\d+/);
            if (daysText) days = parseInt(daysText[0]);
        }

        document.getElementById('nombre_jours').value = days;

        // Calculer le prix total
        const totalPrice = scooterPrice * days;

        // Mettre à jour le prix total
        document.querySelector('.fw-bold.fs-3').textContent = totalPrice.toFixed(2) + ' €';

        // Update the hidden input fields for total price and duration
        document.getElementById('montant').value = totalPrice.toFixed(2);

        // Activer le bouton PAYER
        const paymentButton = document.getElementById('paymentButton');
        const messageElement = document.getElementById('GetScooterMsg');

        paymentButton.textContent = `PAYER ${totalPrice.toFixed(2)} €`;
        paymentButton.disabled = false;
        paymentButton.style.opacity = '1';
        paymentButton.style.cursor = 'pointer';
        // messageElement.style.display = 'none';

        // Stocker en sessionStorage pour les étapes suivantes
        sessionStorage.setItem('selectedScooter', JSON.stringify({
            id: scooterId,
            name: scooterName,
            price: scooterPrice,
            days: days,
            total: totalPrice
        }));

        // Faire défiler jusqu'au formulaire de réservation
        // document.querySelector('section').scrollIntoView({
        //     behavior: 'smooth'
        // });

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

        // const selectedIcon = document.getElementById(`checked-icon-${scooterId}`);
        // if (selectedIcon) {
        //     selectedIcon.style.display = 'block'; // Show the icon for the selected scooter
        // }
    }

    // Gestion du clic sur le bouton PAYER
    document.getElementById('paymentButton').addEventListener('click', function() {
        const selectedScooter = JSON.parse(sessionStorage.getItem('selectedScooter'));

        if (!selectedScooter || selectedScooter.total <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Sélection requise',
                text: 'Veuillez sélectionner un scooter avant de payer',
                confirmButtonColor: '#F2C885'
            });
            return;
        }

        // Soumission du formulaire
        // document.querySelector('form[action="{{-- route('reservation.create') --}}"]').submit();
    });
</script>

<style>
    /* Style minimaliste pour les champs de formulaire */
    .contact-form input,
    .contact-form textarea {
        background: transparent !important;
        border: none !important;
        border-bottom: 1px solid #fff !important;
        /* Ligne jaune en bas */
        border-radius: 0 !important;
        padding-left: 0 !important;
        color: white !important;
        box-shadow: none !important;
    }

    .contact-form input:focus,
    .contact-form textarea:focus {
        outline: none !important;
        border-bottom: 2px solid #fff !important;
        /* Ligne plus épaisse au focus */
        background: transparent !important;
    }

    .contact-form label {
        color: #fff !important;
        font-weight: 500;
    }

    /* Style pour les radios */
    /* .contact-form .form-check-input {
        margin-top: 0.2em;
    }

    .contact-form .form-check-label {
        color: white !important;
        margin-left: 5px;
    } */
    .spacer{
        display: block;
    }

    @media screen and (min-width: 768px) {
        .spacer {
            display: none;
        }
    }
</style>
@endsection