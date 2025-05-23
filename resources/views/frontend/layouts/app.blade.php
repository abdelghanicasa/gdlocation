<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GD Location de scooter neuf en corse bastia, location moto, scooter, tmax, aprilia en france')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles') <!-- pour ajouter des styles custom dans les vues enfants -->
    @include('frontend.partials.head')
    <!-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script> -->
 
</head>
<body>

    @include('frontend.partials.header')

    <main class="container py-4">
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts') 
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const fields = document.querySelectorAll('input, textarea, select');

        fields.forEach(field => {
            field.oninvalid = function (e) {
                // Réinitialiser le message à chaque fois
                this.setCustomValidity('');

                // Personnalisation des messages d'erreur
                if (!this.validity.valid) {
                    if (this.validity.valueMissing) {
                        this.setCustomValidity('Ce champ est requis.');
                    } else if (this.type === 'email' && this.validity.typeMismatch) {
                        this.setCustomValidity("Veuillez entrer une adresse email valide, ex : exemple@domaine.com");
                    } else if (this.validity.patternMismatch) {
                        this.setCustomValidity("Le format du champ est invalide.");
                    } else if (this.validity.tooShort) {
                        this.setCustomValidity(`Le champ doit contenir au moins ${this.minLength} caractères.`);
                    }
                }
            };

            // Réinitialiser dès que l'utilisateur saisit quelque chose
            field.oninput = function () {
                this.setCustomValidity('');
            };
        });
});
</script>


</body>
</html>
