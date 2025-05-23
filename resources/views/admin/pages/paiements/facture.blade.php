<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { display: flex; justify-content: space-between; }
        .total { font-weight: bold; font-size: 1.2em; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h2>{{ $societe['nom'] }}</h2>
            <p>SIRET: {{ $societe['siret'] }}</p>
        </div>
        <div>
            <h1>FACTURE #{{ $paiement->reference }}</h1>
            <p>Date: {{ now()->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="details">
        <h3>Client</h3>
        <p>{{ $paiement->reservation->nom }} {{ $paiement->reservation->prenom }}</p>
        <p>{{ $paiement->reservation->email }}</p>
    </div>

    <table width="100%">
        <tr>
            <th>Description</th>
            <th>Montant</th>
        </tr>
        <tr>
            <td>Location scooter {{ $paiement->reservation->scooter->modele }}</td>
            <td>{{ number_format($paiement->montant, 2) }} €</td>
        </tr>
    </table>

    <div class="total">
        Total TTC: {{ number_format($paiement->montant, 2) }} €
    </div>
</body>
</html>