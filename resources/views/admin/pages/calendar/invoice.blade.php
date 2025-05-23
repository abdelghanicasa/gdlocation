<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture {{ $reservation->reference }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .header { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .logo { height: 70px; }
        h1 { font-size: 24px; color: #333; }
        .info-table { width: 100%; margin: 20px 0; }
        .info-table td { padding: 5px 0; }
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th { background: #f5f5f5; text-align: left; padding: 8px; }
        .items-table td { padding: 8px; border-bottom: 1px solid #eee; }
        .total { text-align: right; margin-top: 20px; font-size: 18px; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; }
    </style>
</head>
<body>

    <div class="invoice-box">
        <div class="row">
            <div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <!-- Logo à gauche -->
            <div style="flex: 1;">
                <h2>GD LOCATION</h2>
            </div>

            <!-- Infos facture à droite sur la même ligne -->
            <div style="flex: 1; text-align: right;">
                <h1 style="margin: 0;">FACTURE</h1>
                <p style="margin: 2px 0;"><strong>N°:</strong> {{ substr($reservation->reference, 0, 7) }}</p>
                <p style="margin: 2px 0;"><strong>Date:</strong> {{ now()->format('d/m/Y') }}</p>
            </div>
        </div>


        </div>

        <table class="info-table">
            <tr>
                <td width="50%">
                    <strong>Client:</strong><br>
                    {{ $reservation->prenom }} {{ $reservation->client->nom }}<br>
                    {{ $reservation->adresse }}<br>
                    {{ $reservation->code_postal }} {{ $reservation->client->ville }}<br>
                    Tél: {{ $reservation->client->tel }}<br>
                    Email: {{ $reservation->client->email }}
                </td>
                <td>
                    <strong>Période de location:</strong><br>
                    Du {{ date('d/m/Y', strtotime($reservation->start)) }}<br>
                    Au {{ date('d/m/Y', strtotime($reservation->end)) }}<br>
                    Durée: {{ $reservation->nombre_jours }} jours<br>
                    Lieu: {{ $reservation->client->ville ?? '-' }} - {{ $reservation->client->pays ?? '-' }}
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $reservation->title }}</td>
                    <td>100 €</td>
                    <td>{{ $reservation->nombre_jours }} jours</td>
                    <td>{{ $reservation->nombre_jours * 100 }} €</td>
                </tr>
                <!-- Options supplémentaires si besoin -->
                <tr>
                    <td colspan="3" style="text-align: right;">Sous-total:</td>
                    <td>200 €</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">TVA (20%):</td>
                    <td>200 €</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold;">Total TTC:</td>
                    <td style="font-weight: bold;">220 €</td>
                </tr>
            </tbody>
        </table>

        <div class="payment-info">
            <p><strong>Statut du paiement:</strong> 
                <span style="color: {{ $reservation->etat_paiement === 'confirmée' ? 'green' : 'orange' }}">
                    {{ ucfirst($reservation->etat_paiement) }}
                </span>
            </p>
            <p><strong>Méthode de paiement:</strong> Carte bancaire</p>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>{{ config('app.name') }} - SIRET: 92785483600016</p>
            <p>Téléphone : 06 24 51 53 42 - Email: gd.loc2b@gmail.com</p>
            <p>Merci pour votre confiance !</p>
        </div>
    </div>
</body>
</html>