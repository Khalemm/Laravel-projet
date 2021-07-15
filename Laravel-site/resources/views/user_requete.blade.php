@extends('layouts.app')
@section('titre')
Evaluations
@endsection
@section('contenu')

<br>

@if(Session::has('info'))
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>   
      {{Session::get('info')}}
    </div>
@endif

<h1><ul> <li>Vos requetes :</li></ul></h1> <!-- affiche les requetes de l'utilisateur -->
<hr>
<div class="row row-cols-1 row-cols-md-3 g-4"  style="margin-left: 0.5rem; text-align: center;">
@forelse($user->requetes as $requete)
  <div class="col">
    <div class="card h-75" style="margin-bottom: 50px;" >
      <div class="card-header">{{ $requete->adresse }}</div>
      <div class="card-body" style="text-align: center;">
        <p class="card-text">
          {{ $requete-> type_bien }}<br>
          {{ $requete-> age_bien }}<br>
          {{ $requete-> nombre_pieces }} pièce(s)
          @if ($requete-> nombre_pieces == 5) et plus @endif <br>
          Avec un prix allant de {{ preg_replace('/(?<=\d)(?=(\d{3})+$)/', ' ', $requete->prix_min) }} 
          à {{ preg_replace('/(?<=\d)(?=(\d{3})+$)/', ' ', $requete->prix_max) }} €
        </p>
      </div>
      <div class="card-footer" style="text-align: center;">
        <a href="{{ route('requete.show', [ 'reqid' => $requete->id]) }}" class="btn btn-primary" style="margin-right:15px;">Voir sur la carte</a>
        <a href="{{ route('requete.delete', [ 'reqid' => $requete->id]) }}" onclick="return confirm('Confirmer la suppression de la requete')" class="btn btn-danger">Supprimer</a>
      </div>
    </div>
    <br>
  </div>
@empty
    <span>Vous n'avez pas de requetes</span>
@endforelse
</div>
@endsection