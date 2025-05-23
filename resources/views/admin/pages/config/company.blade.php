@extends('admin.app')

@section('content')

    <div class="iq-card">
        <div class="iq-card-header">
            <h4 class="card-title">Informations de la société</h4>
        </div>
        <div class="iq-card-body">
            <form action="{{ route('company.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nom de la société *</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $company->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $company->email) }}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Téléphone *</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $company->phone) }}" required>
                </div>
                <div class="form-group">
                    <label for="address">Adresse *</label>
                    <textarea class="form-control" name="address" id="address" rows="3" required>{{ old('address', $company->address) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="logo">Logo</label>
                    <input type="file" class="form-control" name="logo" id="logo">
                    @if(!empty($company->logo))
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo actuel" class="img-thumbnail" width="200">
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="social_networks">Réseaux sociaux (JSON)</label>
                    <textarea class="form-control" name="social_networks" id="social_networks" rows="3" placeholder='{"facebook": "https://facebook.com", "twitter": "https://twitter.com"}'>
                        {{ old('social_networks', json_encode(json_decode($company->social_networks, true), JSON_PRETTY_PRINT)) }}
                    </textarea>
                    <small class="text-muted">Entrez les réseaux sociaux au format JSON. Exemple : {"facebook": "https://facebook.com", "twitter": "https://twitter.com"}</small>
                </div>
                @if(!empty($company->social_networks))
                    @php
                        $socialNetworks = json_decode($company->social_networks, true) ?? [];
                    @endphp
                    @if(is_array($socialNetworks))
                        <div class="social-networks">
                            <h5>Réseaux sociaux</h5>
                            <ul>
                                @foreach($socialNetworks as $platform => $url)
                                    <li>
                                        <a href="{{ $url }}" target="_blank">{{ ucfirst($platform) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif

                <div class="form-group">
                    <label for="horaires">Horaire D'ouverture De La Boutique</label>
                    <textarea class="form-control" name="horaires" id="horaires" rows="3">{{ old('horaires', $company->horaires) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="saison">Saison</label>
                    <input type="text" class="form-control" name="saison" id="saison" value="{{ old('saison', $company->saison) }}">
                </div>

                <div class="form-group">
                    <label for="note">Note</label>
                    <textarea class="form-control" name="note" id="note" rows="3">{{ old('note', $company->note) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="horaires">Horaires</label>
                    <textarea class="form-control" name="horaires" id="horaires" rows="3">{{ old('horaires', $company->horaires) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="tax_info">Informations TVA</label>
                    <textarea class="form-control" name="tax_info" id="tax_info" rows="3">{{ old('tax_info', $company->tax_info) }}</textarea>
                </div>
                <button type="submit" class="btn btn-light">
                     Enregistrer
                </button>
            </form>
        </div>
    </div>

@endsection
