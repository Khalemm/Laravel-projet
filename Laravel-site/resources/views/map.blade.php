@extends('layouts.app')
@section('titre')
Résultat
@endsection

@section('scripts')
<!-- leaflet -->
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
    <div class="row margin-fix">
      <!-- map et cards -->
      <div class="col-gauche">
        <div class="row margin-fix">
          <div id="mapid"></div>
        </div>
        
        <div class="row margin-fix defilement-cartes">
          @include('partials.cartes',['listebiens' => $listebiens])
        </div>
      </div>
      <!-- analyse des biens -->
      <div class="col-droite">
      <br>
      <h2>Analyse des biens</h2>
      @forelse ($commune as $info_commune)
        <p>Population dans la commune {{$info_commune->nom_commune}} : {{preg_replace('/(?<=\d)(?=(\d{3})+$)/', ' ', $info_commune->population)}}.</p>
        <p>Code commune : {{$info_commune->code_commune}} </p>
      @empty
      <span>Les données sur la population de la commune ne sont pas encore disponibles.</span>
      @endforelse
      @if ($analyses)
        <table class="table caption-top">
          <thead>
            <tr>
              <th scope="col">Annee</th>
              <th scope="col">Catégorie</th>
              
              <th scope="col">Code Postal</th>
              <th scope="col">Code Commune</th>
              
              <th scope="col">Moyenne prix m2</th>
              <th scope="col">Moyenne surface m2</th>
              <th scope="col">Nombre de transactions</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($analyses as $analyse)
            <tr>
              <th scope="row">{{$analyse->annee_mutation}}</th>
              <td>{{$analyse->categorie}}</td>
              
              <td>{{$analyse->code_postal}}</td>
              <td>{{$analyse->code_commune}}</td>
              
              <td>{{preg_replace('/(?<=\d)(?=(\d{3})+$)/', ' ', $analyse->avg_prix_m2)}}€</td>
              <td>{{$analyse->avg_surface_m2}}</td>
              <td>{{$analyse->nb_transactions}}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      @else
        <span>L'analyse de votre requete n'est pas encore disponible.</span>
      @endif
      </div>
      
    </div>
</div>
@endsection

@section('scripts-pied')

@include('partials.jsmap',['listebiens' => $listebiens,'requeteinitial' => $requeteinitial])

@endsection