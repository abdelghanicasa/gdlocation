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


    
    <!-- // const cs_datetimes_start = document.getElementById('cs_datetimes_start');
    // const cs_datetimes_end = document.getElementById('cs_datetimes_end');

    // const date = new Date();
    // date.setMilliseconds(0)
    // cs_datetimes_start.valueAsDate = date;
    // cs_datetimes_end.value = date.toLocaleString(); -->

    <!-- NEW -->
<!-- <script>
  window.addEventListener('DOMContentLoaded', () => {
    const startInput = document.querySelector('input[name="cs_datetimes_start"]');
    const endInput = document.querySelector('input[name="cs_datetimes_end"]');

    function formatDateTimeLocal(date) {
      const pad = (n) => n.toString().padStart(2, '0');
      return `${date.getFullYear()}-${pad(date.getMonth()+1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
    }

    function roundToNearestHalfHour(date) {
      const minutes = date.getMinutes();
      if (minutes < 15) {
        date.setMinutes(0);
      } else if (minutes < 45) {
        date.setMinutes(30);
      } else {
        date.setHours(date.getHours() + 1);
        date.setMinutes(0);
      }
      date.setSeconds(0);
      date.setMilliseconds(0);
      return date;
    }

    if (startInput && endInput) {
      const now = roundToNearestHalfHour(new Date());
      const tomorrow = new Date(now.getTime() + 24 * 60 * 60 * 1000);

      if (!startInput.value) {
        startInput.value = formatDateTimeLocal(now);
      }
      if (!endInput.value) {
        endInput.value = formatDateTimeLocal(tomorrow);
      }

      startInput.setAttribute('step', '1800');  // 30 minutes
      endInput.setAttribute('step', '1800');

      startInput.addEventListener('click', () => { if (startInput.showPicker) startInput.showPicker(); });
      endInput.addEventListener('click', () => { if (endInput.showPicker) endInput.showPicker(); });
    }
  });

  document.querySelectorAll('input[type="datetime-local"]').forEach(input => {
  input.addEventListener('change', () => {
    let date = new Date(input.value);
    if (isNaN(date)) return; // si date invalide, on stop

    let minutes = date.getMinutes();

    if (minutes < 15) {0
      date.setMinutes(0);
    } else if (minutes < 45) {
      date.setMinutes(30);
    } else {
      date.setHours(date.getHours() + 1);
      date.setMinutes(0);
    }
    date.setSeconds(0);
    date.setMilliseconds(0);

    // Reformater au format yyyy-MM-ddTHH:mm (datetime-local)
    const pad = n => n.toString().padStart(2, '0');
    const newVal = `${date.getFullYear()}-${pad(date.getMonth()+1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;

    input.value = newVal;
  });
});

</script> -->

<script>
    $(document).ready(function() {
        // Configuration des dates
        const now = moment().minutes(0).seconds(0);
        const tomorrow = moment().add(1, 'days').minutes(0).seconds(0);

        // Affichage initial
        $('.cs_start_date').text(now.format('YYYY-MM-DD HH:mm'));
        $('.cs_end_date').text(tomorrow.format('YYYY-MM-DD HH:mm'));

        // Configuration des pickers
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

        // Picker de départ
        $('#cs_datetimes_start').daterangepicker({
            ...timePickerOptions,
            singleDatePicker: true,
            startDate: now,
            minDate: now
        }, function(start) {
            // updateDates(start, $('#cs_datetimes_end').data('daterangepicker').startDate);
        });

        // Picker de retour
        $('#cs_datetimes_end').daterangepicker({
            ...timePickerOptions,
            singleDatePicker: true,
            startDate: tomorrow,
            minDate: tomorrow
        }, function(end) {
            // updateDates($('#cs_datetimes_start').data('daterangepicker').startDate, end);
        });

        // Fonction pour mettre à jour les dates et calculer la durée
        // function updateDates(start, end) {
        //     // Formatage et affichage
        //     const startFormatted = start.format('YYYY-MM-DD HH:mm');
        //     const endFormatted = end.format('YYYY-MM-DD HH:mm');
            
        //     $('.cs_start_date').text(startFormatted);
        //     $('.cs_end_date').text(endFormatted);
        //     $('#cs_datetimes_start').val(startFormatted);
        //     $('#cs_datetimes_end').val(endFormatted);

        //     // Calcul des jours (1h = 1 jour)
        //     const diffHours = Math.ceil(end.diff(start, 'hours', true));
        //     const diffDays = Math.ceil(diffHours / 24);

        //     // Affichage du récapitulatif
        //     $('#summaryPeriod').text(`${start.format('DD/MM/YYYY HH:mm')} → ${end.format('DD/MM/YYYY HH:mm')}`);
        //     $('#summaryDays').text(diffDays);
        //     $('#reservationSummary').show();
        // }

        // Gestion du clic sur les spans de date
        $('.cs_start_date, .cs_end_date').click(function() {
            const targetId = $(this).hasClass('cs_start_date') ? '#cs_datetimes_start' : '#cs_datetimes_end';
            $(targetId).trigger('click');
        });

        // Initialisation
        // updateDates(now, tomorrow);
    });
</script>

<!-- <script>

/* OLD*/ */
document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour arrondir aux minutes 00 ou 30
    function roundToNearestHalfHour(date) {
        const minutes = date.getMinutes();
        const newDate = new Date(date);
        
        if (minutes > 0 && minutes < 30) {
            newDate.setMinutes(30);
        } else if (minutes > 30) {
            newDate.setHours(newDate.getHours() + 1, 0);
        }
        return newDate;
    }

    // Récupération des valeurs stockées
    const getStoredValue = (key, defaultValue) => {
        const stored = sessionStorage.getItem(key);
        return stored ? new Date(stored) : defaultValue;
    };

    // Dates par défaut
    const now = roundToNearestHalfHour(new Date());
    const tomorrow = roundToNearestHalfHour(new Date());
    tomorrow.setDate(tomorrow.getDate() + 1);

    // Configuration pour le départ
    const startPicker = flatpickr("#cs_datetimes_start", {
        enableTime: true,
        dateFormat: "Y-m-d\\TH:i",
        // dateFormat: "Y-m-d H:i",
        // time_24hr: true,
        locale: "fr",
        minDate: "today",
        minuteIncrement: 30,
        defaultDate: getStoredValue('departure_datetime', now),
        onReady: function(selectedDates, dateStr, instance) {
            const roundedDate = roundToNearestHalfHour(selectedDates[0] || now);
            instance.setDate(roundedDate);
            sessionStorage.setItem('departure_datetime', roundedDate.toISOString());
        },
        onChange: function(selectedDates, dateStr, instance) {
            const minutes = selectedDates[0].getMinutes();
            let correctedDate = selectedDates[0];
            
            if (minutes !== 0 && minutes !== 30) {
                correctedDate = roundToNearestHalfHour(selectedDates[0]);
                instance.setDate(correctedDate);
            }
            
            sessionStorage.setItem('departure_datetime', correctedDate.toISOString());
            
            const endDate = endPicker.selectedDates[0];
            if (endDate && correctedDate >= endDate) {
                const newEndDate = new Date(correctedDate);
                newEndDate.setHours(newEndDate.getHours() + 1);
                endPicker.setDate(roundToNearestHalfHour(newEndDate));
            }
        },
        nextArrow: '<i class="fas fa-chevron-right" style="color: white;"></i>',
        prevArrow: '<i class="fas fa-chevron-left" style="color: white;"></i>'
    });

    // Configuration pour le retour
    const endPicker = flatpickr("#cs_datetimes_end", {
        enableTime: true,
        // dateFormat: "Y-m-d\\TH:i",
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        locale: "fr",
        minDate: "today",
        minuteIncrement: 30,
        defaultDate: getStoredValue('return_datetime', tomorrow),
        onReady: function(selectedDates, dateStr, instance) {
            const roundedDate = roundToNearestHalfHour(selectedDates[0] || tomorrow);
            instance.setDate(roundedDate);
            sessionStorage.setItem('return_datetime', roundedDate.toISOString());
        },
        onChange: function(selectedDates, dateStr, instance) {
            const minutes = selectedDates[0].getMinutes();
            let correctedDate = selectedDates[0];
            
            if (minutes !== 0 && minutes !== 30) {
                correctedDate = roundToNearestHalfHour(selectedDates[0]);
                instance.setDate(correctedDate);
            }
            
            sessionStorage.setItem('return_datetime', correctedDate.toISOString());
            
            const startDate = startPicker.selectedDates[0];
            if (startDate && correctedDate <= startDate) {
                const newEndDate = new Date(startDate);
                newEndDate.setHours(newEndDate.getHours() + 1);
                instance.setDate(roundToNearestHalfHour(newEndDate));
            }
        },
        nextArrow: '<i class="fas fa-chevron-right" style="color: white;"></i>',
        prevArrow: '<i class="fas fa-chevron-left" style="color: white;"></i>'
    });

    // Gestion de l'âge du conducteur
    const ageSelect = document.getElementById('age_conducteur');
    const storedAge = sessionStorage.getItem('driver_age');
    if (storedAge) {
        ageSelect.value = storedAge;
    }
    ageSelect.addEventListener('change', function() {
        sessionStorage.setItem('driver_age', this.value);
    });
});
</script> -->
<style>
	
</style>