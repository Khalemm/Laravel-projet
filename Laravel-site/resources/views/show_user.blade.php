@extends('layouts.entete-pied')
@section('titre')
profil
@endsection
@section('contenu')

<h1>Profil :</h1>
<h2>{{ $user->name }}</h2>

<h3>Vos requetes :</h3> <!-- affiche les requetes des users -->
<div class="row">
@forelse($user->requetes as $requete)
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{ $requete->adresse }}</h5>
        <p class="card-text">
            <ul>
                <li>{{ $requete-> type_bien }}</li>
                <li>{{ $requete-> age_bien }}</li>
                <li>{{ $requete-> nombre_pieces }} pièces</li>
                <li>Avec un prix allant de {{ $requete-> prix_min }} à {{ $requete-> prix_max }}€</li>
            </ul>
        </p>
        <a href="#" class="btn btn-primary">Voir sur la carte</a>
      </div>
    </div>
  </div>


@empty
    <span>Vous n'avez pas de requetes</span>
@endforelse
</div>
@endsection