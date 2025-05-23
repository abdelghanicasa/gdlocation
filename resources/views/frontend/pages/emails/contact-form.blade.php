<!DOCTYPE html>
<html>
<head>
    <title>Nouveau message de contact</title>
</head>
<body>
    <h2>Détails du message</h2>
    
    <p><strong>Nom:</strong> {{ $data['nom'] }}</p>
    <p><strong>Prénom:</strong> {{ $data['prenom'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Téléphone:</strong> {{ $data['telephone'] }}</p>
    <p><strong>Sujet:</strong> {{ $data['sujet'] }}</p>
    
    <h3>Message:</h3>
    <p>{{ $data['message'] }}</p>
    
    <hr>
    <p>Envoyé le {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>