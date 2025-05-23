    <div class="email-container">
        <h2>Confirmation de votre réservation</h2>

        <p>Bonjour {{ $reservation->prenom }},</p>

        <p>Merci pour votre réservation. Celle-ci a bien été enregistrée.<br>
        Voici le récapitulatif de votre commande :</p>

        <ul>
            <li><strong>Scooter réservé :</strong> {{ $reservation->scooter_modele }}</li>
            <li><strong>Période de location :</strong></li>
            <ul>
                <li>Départ : {{ $reservation->date_depart }} à {{ $reservation->heure_depart }}</li>
                <li>Retour : {{ $reservation->date_retour }} à {{ $reservation->heure_retour }}</li>
            </ul>
            <li><strong>Lieu de retrait :</strong> 2178 route de l’aéroport 20290 Lucciana</li>
            <li><strong>Tarif total :</strong> {{ $reservation->montant }} € TTC</li>
            <li>
                <p><strong>Caution :</strong> 1 500 € (non encaissée) [pour le 125]</p>
                <p><strong>Caution :</strong> 2000€ (non encaissée) [pour le T-max]</p>

            </li>
        </ul> 

        <p>La caution se fera à l’agence le jour du départ.</p>

        <p>Si vous avez la moindre question ou si vous souhaitez modifier votre réservation, notre équipe est à votre disposition.</p>

        <p>À très bientôt,<br>
        L’équipe <strong>GD Location</strong></p>

        <div class="footer">
            © {{ date('Y') }} GD Location. Tous droits réservés.
        </div>
    </div>

    <style>
        
    </style>