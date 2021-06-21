@extends('layouts.entete-pied')
@section('titre')
profil
@endsection
@section('contenu')

<h1>Vos requetes :</h1> <!-- affiche les requetes de l'utilisateur -->
<hr>
<div class="row"  style="margin-left: 0.5rem; text-align: center;">
@forelse($user->requetes as $requete)
  <div class="col-sm-4">
    <div class="card h-75" style="margin-bottom: 50px;" > <!-- h-100 -->
      <div class="card-header" style="font-weight:bold;">{{ $requete->adresse }}</div>
      <div class="card-body" style="text-align: center;">
        <!--<h5 class="card-title" ></h5>-->
        <p class="card-text">
          {{ $requete-> type_bien }}<br>
          {{ $requete-> age_bien }}<br>
          {{ $requete-> nombre_pieces }} pièce(s)<br>
          Avec un prix allant de {{ $requete-> prix_min }} à {{ $requete-> prix_max }}€
        </p>
      </div>
      <div class="card-footer" style="text-align: center;">
        <a href="{{ route('requete.show', [ 'reqid' => $requete->id]) }}" class="btn btn-outline-primary" style="margin-right:15px;">Voir sur la carte</a>
        <a href="{{ route('requete.delete', [ 'id' => $user->id ,'reqid' => $requete->id]) }}" class="btn btn-outline-danger">Supprimer</a>
      </div>
    </div>
    <br>
  </div>
@empty
    <span>Vous n'avez pas de requetes</span>
@endforelse
</div>
@endsection