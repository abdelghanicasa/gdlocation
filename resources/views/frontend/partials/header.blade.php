<header class="cs_site_header cs_style_1 cs_transparent_header cs_primary_color cs_sticky_header">
	<div class="cs_main_header">
		<div class="container">
			<div class="cs_main_header_in">
				<div class="cs_main_header_left">
					<div class="cs_main_header_left z-10">
						<a href="{{ route('accueil') }}" class="cs_site_branding">
							<h2 class="cs_bold">GD-LOCATION</h2>
						</a>
					</div>
				</div>
				<!-- <div class="cs_main_header_center">

				</div> -->
				<div class="cs_main_header_right">
					<nav class="cs_nav cs_fs_13 cs_semibold">
						<ul class="cs_nav_list text-center">
							<li class="">
								<a href="{{ route('scooter') }}">Nos scooters</a>
							</li>

							<li><a href="contact">Contact</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- End Header Section -->

<!-- Start Hero Section -->
<section class="position-relative"> <!-- Make section relative for absolute positioning -->
	<!-- Background Block (Behind Slider) -->
	<div class="cs_background_block" style="
            /* position: absolute; */
            top: 0;
            left: 0;
            width: 100%;
            /* height: 100%; */
            background: linear-gradient(to right, #000000, #434343);  
            z-index: 1;  
        "></div>

	<!-- Slider (z-index: 5) -->
	<div class="gradient-div  cs_parallax_slider  loading overflow-hidden position-relative" style="z-index: 5;">
		<div class="swiper-wrapper">
			<div class="swiper-slide">
				<div class="cs_hero cs_style_1 mx-auto">
					<!-- tmax.png (on top of background) -->
					<figure
						class="cs_swiper_parallax_bg cs_hero_bg cs_bg_filed h-100 w-100 position-absolute top-0 start-0 mb-0 img-fluid"
						data-src="{{ asset('fe/img/tmax.png') }}">
					</figure>

					<div class="container position-relative cs_zindex_3">
						<div class="cs_hero_text">
							<h1 style="letter-spacing:1.2rem ;" class="cs_hero_title cs_fs_89 cs_white_color mb-0 fw-lighter">
								LOCATION DE
								<br>
							</h1>
							<span style="letter-spacing: 0.8rem;" class="cs_bold cs_fs_50 text-uppercase">Scooters neufs</span>
						</div>
					</div>

				</div>


			</div>
		</div>
		@php
		use Carbon\Carbon;
		$defaultStart = old('cs_datetimes_start') ? Carbon::parse(old('cs_datetimes_start')) : now()->addHour();
		$defaultEnd = old('cs_datetimes_end') ? Carbon::parse(old('cs_datetimes_end')) : now()->addDay();
		@endphp

		<!-- Form (Below Slider) -->
		<div class="position-relative" style=" z-index: 10;"> <!-- Higher z-index to stay on top -->
			<div class="container-md rounded-3" style="padding:20px; background-color:#3D322B; padding: 40px; margin-top: -60px;">
				<div>
					<form action="{{ route('reservation') }}" method="POST">
						@csrf
						<div class="row g-3 align-items-center">
							<!-- Départ -->
							<div class="col-md-3">
								<label for="departure_datetime" class="form-label text-white">Date et heure de départ</label>
								<div class="position-relative">

									<!-- //LASTWORKD -->
									<div class="cs_date_items">
										<!-- <label for="start_date">Date et heure de départ</label> -->
										<input
											type="text"
											id="cs_datetimes_start"
											name="cs_datetimes_start"
											value="{{ old('cs_datetimes_start') }}"
											class="cs_start_picker"
											style="background-color: #5B4B41; color: white; padding-right: 40px; border: 1px solid black">
										<!-- <div class="cs_form_item cs_date_item"> style="background-color: #5B4B41; color: white; border: 1px solid black;
													<span class="cs_start_date cs_white_color"></span>
												</div> -->
									</div>
									<i class="fa fa-calendar-alt position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); color: white;"></i>
								</div>
							</div>

							<!-- Retour -->
							<div class="col-md-3">
								<label for="departure_datetime" class="form-label text-white">Date et heure de retour</label>
								<div class="position-relative">
									<div class="cs_date_items">
										<!-- <label for="end_date">Date et heure de retour</label> -->
										<input
											type="text"
											id="cs_datetimes_end"
											value="{{ old('cs_datetimes_end') }}"
											class="cs_end_picker"
											name="cs_datetimes_end"
											style="background-color: #5B4B41; color: white; padding-right: 40px; border: 1px solid black">
										<!-- <div class="cs_form_item cs_date_item">
													<span class="cs_end_date cs_white_color"></span>
												</div> -->
									</div>
									<i class="fa fa-calendar-alt position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); color: white;"></i>
								</div>


							</div>

							<!-- Âge conducteur -->
							<div class="col-md-3">
								<label for="age_conducteur" class="form-label text-white">Age du conducteur</label>
								<div class="position-relative">
									<div class="cs_date_items">
										<select
											id="age_conducteur"
											name="age_conducteur"
											class="form-control"
											style="background-color: #5B4B41; color: white; padding-right: 40px; border: 1px solid black;">
											<option value="" disabled selected>Age du conducteur</option>
											<script>
												// Génération dynamique des options de 20 à 80 ans
												document.write(Array.from({
														length: 61
													}, (_, i) =>
													`<option value="${i+20}">${i+20} ans</option>`
												).join(''));
											</script>
										</select>
									</div>
									<i class="fa fa-user position-absolute"
										style="right: 15px; top: 50%; transform: translateY(-50%); color: white;"></i>
								</div>
							</div>


							<!-- Bouton réserver -->
							<div class="col-md-3 d-grid">

								<button type="submit"
									class="btn py-3"
									style="background-color: #F2C885; color: #3A2F29; font-weight: bold; border-radius: 10px; min-height: 72px;">
									<svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M8 2V5" stroke="#3A2F29" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" />
										<path d="M16 2V5" stroke="#3A2F29" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" />
										<path d="M3.5 9.09H20.5" stroke="#3A2F29" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" />
										<path d="M21 8.5V17C21 20 19.5 22 16 22H8C4.5 22 3 20 3 17V8.5C3 5.5 4.5 3.5 8 3.5H16C19.5 3.5 21 5.5 21 8.5Z"
											stroke="#3A2F29" stroke-width="1.5" stroke-miterlimit="10" />
										<path d="M15.6947 13.7H15.7037" stroke="#3A2F29" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
										<path d="M15.6947 16.7H15.7037" stroke="#3A2F29" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
										<path d="M11.9955 13.7H12.0045" stroke="#3A2F29" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
										<path d="M11.9955 16.7H12.0045" stroke="#3A2F29" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
										<path d="M8.29431 13.7H8.30329" stroke="#3A2F29" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
										<path d="M8.29431 16.7H8.30329" stroke="#3A2F29" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
									</svg>
									<p>RÉSERVER</p>

								</button>
							</div>
						</div>
					</form>


				</div>
			</div>
		</div>
	</div>


	<!-- <div class="cs_height_50 cs_height_lg_180"></div> -->
</section>
<style>
	.daterangepicker td.off {
		visibility: hidden;
		/* cache les jours hors mois */
		pointer-events: none;
		/* évite clics */
		/* ou display:none si tu veux les retirer complètement mais ça casse la grille */
	}

	/* Style pour l'icône du sélecteur de date native */
	.custom-datetime-input::-webkit-calendar-picker-indicator {
		background: transparent;
		bottom: 0;
		color: transparent;
		cursor: pointer;
		height: auto;
		left: 0;
		position: absolute;
		right: 0;
		top: 0;
		width: auto;
		opacity: 0;
	}

	#cs_datetimes_start,
	#cs_datetimes_end {
		cursor: pointer;
		width: 100%;
		padding: 10px;
		border: 1px solid #ddd;
		border-radius: 4px;
		box-sizing: border-box;
		color: #000;
		background-color: #fff;
	}

	.calendar-icon-marron:hover path {
		stroke: #F2C885 !important;
		/* Couleur de votre bouton */
		transition: stroke 0.3s ease;
	}

	/* Style au focus */
	.custom-datetime-input:focus {
		outline: none;
		box-shadow: 0 0 0 2px rgba(226, 218, 218, 1);
	}

	#cs_datetimes_start::placeholder {
		font-weight: bold;
		opacity: 1;
		color: white;
	}

	#cs_datetimes_end::placeholder {
		font-weight: bold;
		opacity: 1;
		color: white;
	}

	#age_conducteur::placeholder {
		font-weight: bold;
		opacity: 1;
		color: white;
	}

	.cs_date_items {
		margin-bottom: 20px;
	}

	label {
		display: block;
		margin-bottom: 5px;
		font-weight: bold;
	}

	input {
		width: 100%;
		padding: 10px;
		border: 1px solid #ddd;
		border-radius: 4px;
		box-sizing: border-box;
	}

	.cs_date_item {
		margin-top: 5px;
		padding: 10px;
		background: #f5f5f5;
		border-radius: 4px;
	}

	.cs_input_full {
		width: 100%;
		max-width: 500px;
		margin: 0 auto;
	}
</style>