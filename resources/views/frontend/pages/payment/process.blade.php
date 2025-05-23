<!DOCTYPE html>
<html>
<head>
    <title>Redirection Paiement</title>
    <script src="{{ $jsUrl }}"></script>
</head>
<body>
    <div id="kr-embedded"></div>

    <script>
        KR.onError(function(error) {
            console.error("Erreur Sogecommerce : ", error);
            alert("Erreur lors du traitement du paiement");
        });

        KR.setFormConfig({
            formToken: "{{ $formToken }}",
            publicKey: "{{ $publicKey }}",
            language: 'fr-FR'
        });

        KR.attachForm('#kr-embedded');
    </script>
</body>
</html>