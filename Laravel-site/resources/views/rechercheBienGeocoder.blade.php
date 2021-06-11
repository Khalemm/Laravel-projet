@extends('layouts.entete-pied')
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

<h1>etape 1</h1>

<form method="POST" action="{{ route('postGeocoder') }}">
    <!-- important, sinon l'info ne passe pas et erreur 417 -->
    @csrf <!-- {{ csrf_field() }} -->
    <label>Chercher une adresse</label>
	<div id="geocoder" class="geocoder"></div><br>
    <div class="form-group">
        <label>Latitude</label>
        <input type="text" name="latitude" readonly="readonly" id="latitude" class="form-control form_data" />
        <span id="latitude_error" class="text-danger"></span>
    </div>
    <div class="form-group">
        <label>Longitude</label>
        <input type="text" name="longitude" readonly="readonly" id="longitude" class="form-control form_data" />
        <span id="latitude_error" class="text-danger"></span>
    </div>
    <div class="form-group">
        <label>Adresse</label>
        <input type="text" name="adresse" readonly="readonly" id="adresse" class="form-control form_data" />
        <span id="adresse_error" class="text-danger"></span>
    </div>
    <div class="form-group">
        <label>Code Postal</label>
        <input type="text" name="code_postal" readonly="readonly" id="code_postal" class="form-control form_data" />
        <span id="code_postal_error" class="text-danger"></span>
    </div>
    <div class="form-group">
        <label>Commune</label>
        <input type="text" name="nom_commune" readonly="readonly" id="nom_commune" class="form-control form_data" />
        <span id="nom_commune_error" class="text-danger"></span>
    </div>
    <button class="btn btn-primary" type="submit">valider</button>
</form>
@endsection

@section('scripts-pied')
<script type="text/javascript" src="{{ asset('js/formulaire-comparaison.js') }}"></script>
@endsection