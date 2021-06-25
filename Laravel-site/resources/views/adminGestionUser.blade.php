@extends('layouts.app')

@section('contenu')

@foreach ((array)$users as $user)
    @if ($user->admin == false)
    <div class="liste-users">
        <div class="popup card liste">
            <div class="haut-de-carte card-header">
                <div class="texte-header">
                    <p>{{$user->name}} {{$user->last_name}}</p></p>
                    <p>{{$user->statut}}</p> 
                </div>
            </div>
            <div class="millieu-de-carte card-body">
                <button type="button" class="btn btn-primary">Activer</button>
                <button type="button" class="btn btn-secondary">Désactiver</button>
                <button type="button" class="btn btn-danger">Supprimer</button>
            </div>
        </div>
    </div>
    @endif
    
    
@endforeach

@endsection
