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
                    {{ $post->page->title }}
                </h2>
                @if (!empty($post->page->content))
                <p>{{ $post->page->content }}</p>
                @endif
                
            </div>
        @else
            <div style="padding: 25px 0px;">
                <p>Aucun article disponible pour le moment.</p>
            </div>
        @endif
    </div>
</section>


@if($posts->isNotEmpty() && isset($post->blocks[0]))
<section>
    <div class="container" bis_skin_checked="1">
        <div class="cs_radius_10 cs_about cs_style_1 gradientDivInversed" style="padding: 3%;" bis_skin_checked="1">
            <div class="row">
                <!-- Colonne Titre + Contenu -->
                <div class="col-md-6 text-left">
                    <div class="cs_section_heading cs_style_1 text-left" bis_skin_checked="1">
                        <h2 class="cs_fs_38">{{ $post->blocks[0]->title }}</h2>
                        <p class="cs_mb_lg_15" style="line-height: 2.3rem; padding-top: 9px;">
                            {!! nl2br(e($post->blocks[0]->content)) !!}
                        </p>
                    </div>
                </div>

                <!-- Colonne Image -->
                <div class="col-md-6">
                    <!-- {{ $firstImage = $post->blocks[0]->image }} -->
                        <img src="{{asset('fe/img/tm.png')}}" class="img-fluid rounded" alt="Image">
                    
                </div>
            </div>
        </div>
    </div>

    <div class="cs_height_50 cs_height_lg_50" bis_skin_checked="1"></div>
</section>

@endif


@if($posts->isNotEmpty() && isset($post->blocks[1]))
<section>
    <div class="container" bis_skin_checked="1">
        <div class="cs_radius_10 cs_about cs_style_1 gradientDivInversed" style="padding: 3%;" bis_skin_checked="1">
            <div class="row align-items-center">
                <!-- Colonne Titre + Contenu -->
                <div class="col-md-6 d-flex justify-content-center">
                    <div class="cs_section_heading cs_style_1 text-left" style="max-width: 90%;">
                        <h2 class="cs_fs_38">{{ $post->blocks[1]->title }}</h2>
                        <p class="cs_mb_lg_15 " style="line-height: 2.3rem; padding-top: 9px;">
                            {!! nl2br(e($post->blocks[1]->content)) !!}
                        </p>
                    </div>
                </div>

                <!-- Colonne Image -->
                <div class="col-md-6 d-flex justify-content-center">
                    @if (!empty($post->blocks[1]->image))
                    <img src="{{asset('fe/img/tmax-1.png')}}" class="img-fluid rounded" alt="Image">
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="cs_height_50 cs_height_lg_50" bis_skin_checked="1"></div>
</section>

@endif



<section>

<!-- <div class="cs_height_50 cs_height_lg_80"></div> -->
</section>

<script>
    // Lors de la soumission du formulaire dans le header
document.querySelector('#reservation-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        startDate: document.getElementById('departure_datetime').value,
        endDate: document.getElementById('return_datetime').value,
        age: document.getElementById('age_conducteur').value
    };
    alert(startDate);
    // Stockage dans LocalStorage
    localStorage.setItem('reservationDates', JSON.stringify(formData));
    
    // Déclenchement d'un événement personnalisé
    const datesUpdatedEvent = new CustomEvent('datesUpdated', { detail: formData });
    window.dispatchEvent(datesUpdatedEvent);
    
    // Redirection vers la page de réservation
    // window.location.href = "{{-- route('reservation') --}}";
});
</script>
<style>
.cs_post.cs_style_1 .cs_hover_icon {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(129, 15, 15, 0.1);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.cs_post.cs_style_1:hover .cs_hover_icon {
    opacity: 1;
}

.cs_post.cs_style_1 img {
    transition: transform 0.3s ease;
}

.cs_post.cs_style_1:hover img {
    transform: scale(1.02);
}
</style>
@endsection