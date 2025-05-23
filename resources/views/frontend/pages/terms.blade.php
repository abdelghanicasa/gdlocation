@extends('frontend.layouts.app')

@section('content')

<!-- Header -->
    <header class="legal-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Mentions Légales</h1>
            <p class="lead">Informations juridiques concernant GD Location</p>
        </div>
    </header>

    <!-- Main Content -->
    <div class="cs_radius_10 cs_about cs_style_1 gradientDivInversed" style="padding: 3%;" bis_skin_checked="1">
        <div class="row">
            <div class="col-lg-8">
                <!-- Éditeur -->
                <section class="legal-section">
                    <h2 class="section-title">INFORMATIONS ÉDITEUR</h2>
                    <p>Le site <strong>www.gd-location.fr</strong> est édité par :</p>
                    
                    <div class="ps-4 mt-4">
                        <h4 class="mb-3"><i class="fas fa-building text-light"></i> GD Location</h4>
                        <address>
                            <p class="mb-1"><i class="fas fa-map-marker-alt text-light"></i> 2178 route de l'aéroport</p>
                            <p class="mb-3">20290 Lucciana</p>
                            <p><i class="fas fa-phone-alt text-light"></i> Tél: 06 24 51 53 42</p>
                        </address>
                    </div>
                </section>

                <!-- Hébergeur -->
                <section class="legal-section">
                    <h2 class="section-title">INFORMATION HÉBERGEUR</h2>
                    <p>Le présente site est hébergé par :</p>
                    
                    <div class="ps-4 mt-4">
                        <h4 class="mb-3"><i class="fas fa-server text-light"></i> OVH</h4>
                        <address>
                            <p class="mb-1"><i class="fas fa-map-marker-alt text-light"></i> 2 rue Kellermann</p>
                            <p class="mb-1">59100 Roubaix</p>
                            <p>France</p>
                        </address>
                    </div>
                </section>

                <!-- Propriété intellectuelle -->
                <section class="legal-section">
                    <h2 class="section-title">PROPRIÉTÉ INTELLECTUELLE</h2>
                    <p>Conformément au code de la Propriété Intellectuelle et plus généralement à tous les accords comportant des dispositions relatives au droit d'auteur, la reproduction partielle ou totale de textes, d'images ou d'illustrations non destinées explicitement à être téléchargées par des visiteurs, sont interdites sans autorisation préalable de l'éditeur ou de tout ayant droit.</p>
                    
                    <div class="alert alert-warning mt-4">
                        <i class="fas fa-exclamation-triangle me-2"></i> Toute utilisation non autorisée des contenus du site peut constituer une contrefaçon sanctionnée par les articles L.335-2 et suivants du Code de la propriété intellectuelle.
                    </div>
                </section>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="contact-info">
                    <h3 class="text-white mb-4"><i class="fas fa-info-circle"></i> Informations</h3>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt"></i>
                            <strong>Adresse :</strong><br>
                            2178 route de l'aéroport<br>
                            20290 Lucciana
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-phone-alt"></i>
                            <strong>Téléphone :</strong><br>
                            06 24 51 53 42
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope"></i>
                            <strong>Email :</strong><br>
                            contact@gd-location.fr
                        </li>
                        <li>
                            <i class="fas fa-globe"></i>
                            <strong>Site web :</strong><br>
                            www.gd-location.fr
                        </li>
                    </ul>
                </div>

                <div class="card mt-4">
                    <div class="card-header bg-light text-dark">
                        <i class="fas fa-file-alt me-2"></i> Documents légaux
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="{{ route('condition') }}" class="text-decoration-none">
                                    <i class="fas fa-file-contract me-2 text-dark"></i> Conditions générales
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('terms') }}" class="text-decoration-none">
                                    <i class="fas fa-user-shield me-2 text-dark"></i> Politique de confidentialité
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="cookies.html" class="text-decoration-none">
                                    <i class="fas fa-cookie-bite me-2 text-dark"></i> Politique des cookies
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
    h2 {
        font-size: 22px;
    }
    h3 {
        font-size: 18px;
    }
</style>
@endsection