@extends('layouts.entete-pied')
@section('titre')
Résultat
@endsection

@section('scripts')
<!-- mapbox -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
@endsection

@section('contenu')
@php
  $listebiens = json_encode(session('res'));
  $requeteinitial = json_encode(session('req'));
@endphp

<div class="page">
    <div class="row">
      <!-- map et cards -->
      <div class="col-8">
        <div class="row mapbox-carte">
          <div id="mapid"></div>
        </div>
        
        <div class="row defilement-cartes" id="test">
          @include('partials.cartes',['listebiens' => $listebiens])
        </div>
      </div>
      <!-- analyse des biens -->
      <div class="analyse-biens col-4">
          <h2>analyse des biens</h2>
      </div>
      
    </div>
</div>
@endsection

@section('scripts-pied')

@include('partials.jsmap',['listebiens' => $listebiens,'requeteinitial' => $requeteinitial])

@endsection