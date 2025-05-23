@extends('frontend.layouts.app')

@section('content')

<!-- Start Title Section -->
<section>
    <div class="container">
        <!-- post content -->
        @if($posts->isNotEmpty())
            @php $post = $posts->first(); @endphp
            <div style="padding: 25px 0px;">
                <h2 class="cs_fs_50 mb-0 wow text-uppercase fw-lighter">
                    {{ $post->title }}
                </h2>
                <p>{{ $post->text }}</p>
            </div>
        @else
            <div style="padding: 25px 0px;">
                <p>Aucun article disponible pour le moment.</p>
            </div>
        @endif
    </div>
</section>

<section>
    <div class="cs_slider cs_style_1 cs_slider_gap_60 cs_hover_show_arrows">
        <div class="container">
            <div class="cs_slider_container" data-autoplay="0" data-loop="1" data-speed="600" data-center="0"
                data-variable-width="0" data-slides-per-view="responsive" data-xs-slides="1" data-sm-slides="2"
                data-md-slides="2" data-lg-slides="3" data-add-slides="2">
                <div class="cs_slider_wrapper">
                    <!-- START -->
                    <!-- Début de la section Scooters -->
                    @foreach($tmaxScooters as $scooter)
                    <div class="cs_slides" >
                        <div class="cs_post cs_style_1 p-3 cs_radius_10" style="background-color: #E5DFDC;">
                            <span href="#" class=" cs_radius_5 overflow-hidden d-block cs_mb_lg_20 position-relative justify-content-center">
                            <img src="{{ asset('storage/' . $scooter->photo) }}" alt="{{ $scooter->modele }}" 
                            style="padding: 20px; width: 500px; object-fit: contain; margin-top: 13px; display: block; margin-left: auto; margin-right: auto;">
                                <div class="cs_hover_icon cs_center position-absolute cs_black_color cs_zindex_2 cs_radius_5">
                                    <h4 style="color: black;">{{ $scooter->marque }} {{ $scooter->modele }}</h4>

                                    <!-- Prix dynamique -->
                                    
                                </div>
                            </span>
                            <!-- Période de validité -->
                            <!-- @foreach($scooter->pricePeriods as $period) -->
                            <!-- @if($period->start_date <= now() && $period->end_date >= now())
                                <small class="period-info">
                                Offre valable du {{ \Carbon\Carbon::parse($period->start_date)->format('d/m/Y') }}

                                    au {{ \Carbon\Carbon::parse($period->end_date)->format('d/m/Y') }}
                                </small>
                                @endif -->
                                <!-- @endforeach -->
                                <!-- Bouton de réservation -->
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('scooter') }}"
                                        class="cs_btn  text-uppercase w-100 cs_style_2 cs_medium cs_radius_5 cs_fs_15"
                                        id="ReservationBtn">
                                        En Savoir Plus
                                        <span>
                                            <i>
                                                <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.00431 0.872828C9.00431 0.458614 8.66852 0.122828 8.25431 0.122828L1.50431 0.122827C1.0901 0.122827 0.754309 0.458614 0.754309 0.872828C0.754309 1.28704 1.0901 1.62283 1.50431 1.62283H7.50431V7.62283C7.50431 8.03704 7.84009 8.37283 8.25431 8.37283C8.66852 8.37283 9.00431 8.03704 9.00431 7.62283L9.00431 0.872828ZM1.53033 8.65747L8.78464 1.40316L7.72398 0.342497L0.46967 7.59681L1.53033 8.65747Z" fill="currentColor" />
                                                </svg>
                                            </i>
                                            <i>
                                                <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.00431 0.872828C9.00431 0.458614 8.66852 0.122828 8.25431 0.122828L1.50431 0.122827C1.0901 0.122827 0.754309 0.458614 0.754309 0.872828C0.754309 1.28704 1.0901 1.62283 1.50431 1.62283H7.50431V7.62283C7.50431 8.03704 7.84009 8.37283 8.25431 8.37283C8.66852 8.37283 9.00431 8.03704 9.00431 7.62283L9.00431 0.872828ZM1.53033 8.65747L8.78464 1.40316L7.72398 0.342497L0.46967 7.59681L1.53033 8.65747Z" fill="currentColor" />
                                                </svg>
                                            </i>
                                        </span>
                                    </a>
                                </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- END -->

                </div>
            </div>
        </div>
        <div class="cs_pagination cs_style_1 cs_mobile_show"></div>
    </div>
    <div class="cs_height_50 cs_height_lg_80"></div>
</section>

<section>
    <div class="container">
        <div class="cs_radius_10 cs_about cs_style_1 gradient-div" style="padding: 3%;">
            <div class="cs_section_heading cs_style_1 text-left">

                <div class="row cs_row_gap_50 cs_gap_y_60">
                    <div class="col-lg-4 col-md-6">
                        @if($posts->isNotEmpty() && isset($post->blocks[0]))
                            <div class="cs_feature_box cs_style_4">
                                <div class="cs_center cs_fs_67 cs_mb_35">
                                    @if($post->blocks[0]->image)
                                        <img src="{{ asset('storage/' . $post->blocks[0]->image) }}" height="60" width="60" class="img-fluid" alt="">
                                    @else
                                        <img src="{{ asset('fe/img/calendar.png') }}" height="60" width="60" class="img-fluid" alt="">
                                    @endif
                                </div>
                                <h2 class="cs_center cs_fs_16  text-uppercase cs_mb_10">{{ $post->blocks[0]->title }}</h2>
                                <p class="text-center mb-0">
                                    {!! nl2br(e($post->blocks[0]->content)) !!}
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-6">
                        @if($posts->isNotEmpty() && isset($post->blocks[1]))
                            <div class="cs_feature_box cs_style_4">
                                <div class="cs_center cs_fs_67 cs_mb_35">
                                    @if($post->blocks[1]->image)
                                        <img src="{{ asset('storage/' . $post->blocks[1]->image) }}" height="60" width="60" class="img-fluid" alt="">
                                    @else
                                        <img src="{{ asset('fe/img/motorcycle.png') }}" height="60" width="60" class="img-fluid" alt="">
                                    @endif
                                </div>
                                <h2 class="cs_center cs_fs_16  text-uppercase cs_mb_10">{{ $post->blocks[1]->title }}</h2>
                                <p class="text-center mb-0">
                                    {!! nl2br(e($post->blocks[1]->content)) !!}
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-6">
                        @if($posts->isNotEmpty() && isset($post->blocks[2]))
                            <div class="cs_feature_box cs_style_4">
                                <div class="cs_center cs_fs_67 cs_mb_35">
                                    @if($post->blocks[2]->image)
                                        <img src="{{ asset('storage/' . $post->blocks[2]->image) }}" height="60" width="60" class="img-fluid" alt="">
                                    @else
                                        <img src="{{ asset('fe/img/credit-card.png') }}" height="60" width="60" class="img-fluid" alt="">
                                    @endif
                                </div>
                                <h2 class="cs_center cs_fs_16 text-uppercase cs_mb_10">{{ $post->blocks[2]->title }}</h2>
                                <p class="text-center mb-0">
                                    {!! nl2br(e($post->blocks[2]->content)) !!}
                                </p>
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="cs_height_50 cs_height_lg_80"></div>
</section>

<section>
    <div class="container">
        <div class="cs_radius_10 cs_about cs_style_1" style="padding: 3%; background-color: #E5DFDC;">
            <div class="cs_section_heading cs_style_1 text-left">
                <div class="row">
                    <!-- Text Column (80%) -->
                    @if($posts->isNotEmpty() && isset($post->blocks[3]))
                    <div class="col-md-8">
                        <h2 class="cs_fs_50 text-uppercase mb-3 text-dark">GD location</h2>
                        <p class="cs_section_subtitle cs_letter_spacing_1 cs_mb_lg_15 cs_fs_16 text-dark">
                            {!! nl2br(e($post->blocks[3]->content)) !!}
                        </p>
                        @endif
                    </div>
                    <!-- Image Column (20%) -->
                    <div class="col-md-4">
                        <img src="{{asset('fe/img/gd-location.png')}}" alt="Scooter" class="img-fluid" style="max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cs_height_50 cs_height_lg_80"></div>
</section>
<style>
    .slick-arrow {
        display: none !important
    }
</style>
<!-- <script>
    // Lors de la soumission du formulaire dans le header
    document.querySelector('#ReservationBtn').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = {
            startDate: document.getElementById('departure_datetime').value,
            endDate: document.getElementById('return_datetime').value,
            age: document.getElementById('age_conducteur').value,
           
        };
        console.log('Form data:', formData); // Debugging line

        // Stockage dans LocalStorage
        localStorage.setItem('reservationDates', JSON.stringify(formData));

        // Déclenchement d'un événement personnalisé
        const datesUpdatedEvent = new CustomEvent('datesUpdated', { detail: formData });
        window.dispatchEvent(datesUpdatedEvent);

        // Redirection vers la page de réservation
        // window.location.href = "{{-- route('reservation') --}}";
    });

    // Lorsqu'un scooter est sélectionné
    document.querySelectorAll('.cs_slides .cs_btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const scooterId = this.getAttribute('href').split('scooter_id=')[1];
            const reservationDates = JSON.parse(localStorage.getItem('reservationDates'));

            if (reservationDates) {
                // Associer les dates au scooter sélectionné
                const reservationData = {
                    scooterId: scooterId,
                    ...reservationDates
                };

                // Stocker les données de réservation globalement
                localStorage.setItem('selectedReservation', JSON.stringify(reservationData));

                // Redirection vers la page de réservation
                window.location.href = this.getAttribute('href');
            } else {
                alert('Veuillez sélectionner les dates avant de réserver un scooter.');
            }
        });
    });
</script> -->
@endsection