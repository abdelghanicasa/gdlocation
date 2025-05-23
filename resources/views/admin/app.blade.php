<!doctype html>
<html lang="en">

<head>
   @include('admin.layouts.partials.head')
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

   @vite(['resources/css/app.css', 'resources/js/app.js'])
   </head>

<body>

   <div class="wrapper">
      @include('admin.layouts.partials.sidebar')
      @include('admin.layouts.partials.top-navbar')

      <!-- Page Content  -->
      <div id="content-page" class="content-page">
         <div class="container-fluid">

            @yield('content') {{-- Le contenu spécifique à chaque vue --}}
            
         </div>
      </div>

      @include('admin.layouts.partials.footer')
   </div>

   @include('admin.layouts.partials.scripts')
   @stack('scripts') <!-- Ton code personnalisé -->
   <script>
          $(document).ready(function() {
        $('#listResa').DataTable({
            order: [
                [0, 'desc']
            ],
            language: {
                "sProcessing": "Traitement en cours...",
                "sSearch": "Rechercher&nbsp;:",
                "sLengthMenu": "Afficher _MENU_ éléments",
                "sInfo": "Affichage de _START_ à _END_ sur _TOTAL_ éléments",
                "sInfoEmpty": "Affichage de 0 à 0 sur 0 élément",
                "sInfoFiltered": "(filtré de _MAX_ éléments au total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords": "Aucun élément correspondant trouvé",
                "sEmptyTable": "Aucune donnée disponible dans le tableau",
                "oPaginate": {
                    "sFirst": "Premier",
                    "sPrevious": "Précédent",
                    "sNext": "Suivant",
                    "sLast": "Dernier"
                },
                "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                }
            }
        });
    });
   </script>
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
                    } else {
                        this.setCustomValidity("Veuillez corriger ce champ.");
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
<style>
   /* Afficher seulement sur mobile (écrans <= 767px) */

</style>
</body>

</html>