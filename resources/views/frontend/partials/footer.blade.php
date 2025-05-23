<!-- Start Footer -->
<footer class=" cs_footer gradient-div mx-auto cs_ternary_color">
    <div class="pt-5">
        <div class="container">
            <div class="cs_footer_grid_4">
                <div class="cs_footer_grid_item">
                    <div class="cs_footer_item text-center">
                        <h2 class="cs_widget_title cs_fs_28 cs_white_color"><span>GD-LOCATION</span></h2>
                        <img src="{{ asset('fe/img/moto_logo.png') }}" alt="GD location, loueur de scooters à Bastia Corse">
                    </div>
                </div>
                <div class="cs_footer_grid_item">
                    <div class="cs_footer_item text-center">
                        <h2 class="cs_widget_title cs_fs_28 cs_white_color"><span>Nos motos</span></h2>
                        <ul class="cs_menu_widget cs_mp0">
                            <li><a href="#">Aprilia 125</a></li>
                            <li><a href="#">Tmax 560</a></li>
                        </ul>
                    </div>
                </div>
                <div class="cs_footer_grid_item">
                    <div class="cs_footer_item text-center">
                        <h2 class="cs_widget_title cs_fs_28 cs_white_color"><span>Conditions</span></h2>
                        <ul class="cs_menu_widget cs_mp0">
                            <li><a href="#">Conditions Générales</a></li>
                            <li><a href="#">Mentions légales</a></li>
                        </ul>
                    </div>
                </div>
                <div class="cs_footer_grid_item">
                    <div class="cs_footer_item text-center">
                        <h2 class="cs_widget_title cs_fs_28 cs_white_color"><span>CONTACT</span></h2>
                        <ul class="cs_menu_widget cs_mp0">
                            <li class="cs_white_color">Tél : <a href="tel:{{ $company->phone }}">{{ $company->phone }}</a></li>
                            <li class="cs_white_color">Email : <a href="mailto:{{ $company->email }}">{{ $company->email }}</a></li>
                            <li class="cs_white_color">{{ $company->address }}</li>
                            <!-- <li>Nous sommes ouverts 24/7</li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cs_bottom_footer_wrap">
        <div class="container">
            <div class="cs_bottom_footer position-relative">
                <span class="cs_scrollup cs_center">
                    <svg width="15" height="7" viewBox="0 0 15 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15 6.18793L14.1169 7L7.93687 1.31723C7.81958 1.20941 7.66053 1.14885 7.49468 1.14885C7.32884 1.14885 7.16978 1.20941 7.0525 1.31723L0.884376 6.99022L0 6.177L6.16812 0.505163C6.51998 0.181708 6.99715 0 7.49468 0C7.99222 0 8.46938 0.181708 8.82125 0.505163L15 6.18793Z"
                            fill="white" />
                    </svg>
                </span>
                <div class="cs_bottom_footer_right">
                    <ul class="cs_footer_links cs_mp_0">
                        <li>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->

<!-- Script -->
<script src="{{ asset('fe/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('fe/js/wow.min.js') }}"></script>
<script src="{{ asset('fe/js/jquery.slick.min.js') }}"></script>
<script src="{{ asset('fe/js/swiper.min.js') }}"></script>
<script src="{{ asset('fe/js/moment.min.js') }}"></script>
<script src="{{ asset('fe/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('fe/js/lightgallery.min.js') }}"></script>
<script src="{{ asset('fe/js/YTPlayer.min.js') }}"></script>
<script src="{{ asset('fe/js/main.js') }}"></script>
<script>(function () { function c() { var b = a.contentDocument || a.contentWindow.document; if (b) { var d = b.createElement('script'); d.innerHTML = "window.__CF$cv$params={r:'928a77c4b9211d43',t:'MTc0MzM2NzcwNi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='https://html.laralink.com/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);"; b.getElementsByTagName('head')[0].appendChild(d) } } if (document.body) { var a = document.createElement('iframe'); a.height = 1; a.width = 1; a.style.position = 'absolute'; a.style.top = 0; a.style.left = 0; a.style.border = 'none'; a.style.visibility = 'hidden'; document.body.appendChild(a); if ('loading' !== document.readyState) c(); else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c); else { var e = document.onreadystatechange || function () { }; document.onreadystatechange = function (b) { e(b); 'loading' !== document.readyState && (document.onreadystatechange = e, c()) } } } })();</script>
<script defer
    src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
    integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
    data-cf-beacon='{"rayId":"928a77c4b9211d43","version":"2025.1.0","r":1,"token":"6f756f02820545e3be40ddc6eb6154c3","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}}}'
    crossorigin="anonymous"></script>
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS + French locale -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('swal_error'))
<script>

document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        html: '{!! session('swal_error') !!}',
        confirmButtonColor: '#F2C885'
    });
});
</script>
@endif

<script>
$(document).ready(function() {
    const getStoredValue = (key, defaultValue) => {
        const stored = sessionStorage.getItem(key);
        return stored ? moment(stored) : defaultValue;
    };

    const now = moment().minutes(0).seconds(0);
    const tomorrow = moment().add(1, 'days').minutes(0).seconds(0);

    const startDate = getStoredValue('cs_datetimes_start', now);
    const endDate = getStoredValue('cs_datetimes_end', tomorrow);
    const ageConducteur = sessionStorage.getItem('age_conducteur') || '';

    const timePickerOptions = {
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 30,
        locale: {
            format: 'YYYY-MM-DD HH:mm',
            applyLabel: 'Valider',
            cancelLabel: 'Annuler',
            daysOfWeek: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            firstDay: 1
        },
        opens: 'right',
        autoUpdateInput: true
    };

    $('#cs_datetimes_start').daterangepicker({
        ...timePickerOptions,
        singleDatePicker: true,
        startDate: startDate,
        minDate: now
    }, function(start) {
        $('#cs_datetimes_start').val(start.format('YYYY-MM-DD HH:mm'));
        sessionStorage.setItem('cs_datetimes_start', start.format());
    });

    $('#cs_datetimes_end').daterangepicker({
        ...timePickerOptions,
        singleDatePicker: true,
        startDate: endDate,
        minDate: now
    }, function(end) {
        $('#cs_datetimes_end').val(end.format('YYYY-MM-DD HH:mm'));
        sessionStorage.setItem('cs_datetimes_end', end.format());
    });

    $('#cs_datetimes_start').val(startDate.format('YYYY-MM-DD HH:mm'));
    $('#cs_datetimes_end').val(endDate.format('YYYY-MM-DD HH:mm'));

    if (ageConducteur) {
        $('#age_conducteur').val(ageConducteur);
    }

    $('#age_conducteur').on('change', function() {
        sessionStorage.setItem('age_conducteur', $(this).val());
    });

    $('.cs_start_date, .cs_end_date').click(function() {
        const targetId = $(this).hasClass('cs_start_date') ? '#cs_datetimes_start' : '#cs_datetimes_end';
        $(targetId).trigger('click');
    });
});
</script>


