@extends('layouts.entete-pied')
@section('titre')
User
@endsection
@section('contenu')

<h1>User :</h1>
<h2>{{ $user->name }}</h2>

<h3>Ses requetes :</h3> <!-- affiche les requetes des users -->
@forelse($user->requetes_biens as $requetes)
    <span><ul><li>{{ $requetes->adresse }}</li></ul></span>
@empty
    <span>Vous n'avez pas de requetes</span>
@endforelse

@endsection