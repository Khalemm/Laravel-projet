@extends('layouts.app')
@section('titre')
Rechercher une adresse
@endsection

@section('scripts')
<!-- mapbox -->
<link href="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.js"></script>
@endsection

@section('contenu')
<!-- mapbox style et plugin -->
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>

<div class="form-exterieur-bg">
    <div class="justify-content-center form-size">
        <div class="etape-form">
            <h1>Etape 1</h1>
        </div>
    
        <div class="formulaire">
            <form method="POST" action="{{ route('postGeocoder') }}">
                <!-- important, sinon l'info ne passe pas et erreur 417 -->
                @csrf <!-- {{ csrf_field() }} -->
                <div class="form-group">
                    <label>Chercher une adresse</label>
                    <div id="geocoder" class="geocoder"></div>
                </div>
                @if ($erreur != null) 
                    <p>Une erreur est survenue lors de la recherche : {{ $erreur }}</p>
                @endif
                @php
                    $erreur == null;
                @endphp
                <input type="hidden" name="latitude" readonly="readonly" id="latitude" class="form-control form_data" />
                <input type="hidden" name="longitude" readonly="readonly" id="longitude" class="form-control form_data" />
                <input type="hidden" name="adresse" readonly="readonly" id="adresse" class="form-control form_data" />
                <input type="hidden" name="code_postal" readonly="readonly" id="code_postal" class="form-control form_data" />
                <input type="hidden" name="nom_commune" readonly="readonly" id="nom_commune" class="form-control form_data" />
                <div class="validation-form">
                    <button class="btn btn-primary" type="submit">valider</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('scripts-pied')
<script type="text/javascript" src="{{ asset('js/formulaire-comparaison.js') }}"></script>
@endsection