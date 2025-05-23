<!-- resources/views/partials/scripts.blade.php -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.appear.js') }}"></script>
<script src="{{ asset('assets/js/countdown.min.js') }}"></script>
<script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/apexcharts.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/smooth-scrollbar.js') }}"></script>
<script src="{{ asset('assets/js/lottie.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/charts.js') }}"></script>
<script src="{{ asset('assets/js/animated.js') }}"></script>
<script src="{{ asset('assets/js/kelly.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('assets/js/chart-custom.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!-- jQuery (obligatoire) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables (après jQuery) -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    flatpickr('input[type="date"], input[type="datetime-local"]', {
        locale: 'fr', // Applique la langue française
        // dateFormat: 'Y-m-d', // Format de date par défaut (tu peux le personnaliser)
    });
});
</script>

