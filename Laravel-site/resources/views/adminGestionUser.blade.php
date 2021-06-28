@extends('layouts.app')

@section('contenu')

@if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>
@endif

@if(Session::has('info'))
    <div class="alert alert-danger">
       {{Session::get('info')}}
    </div>
@endif

@foreach ($users as $user)
    @if ($user->admin == false)
    <div class="liste-users">
        <div class="popup card liste">
            <div class="haut-de-carte card-header">
                <div class="texte-header">
                    <p>{{$user->name}} {{$user->last_name}}</p></p>
                    <p>{{$user->active}}</p> 
                </div>
            </div>
            <div class="millieu-de-carte card-body">
                <a href="{{ route('user.active', [ 'id' => $user->id] ) }}" class="btn btn-primary">Activer</a>
                <a href="{{ route('user.desactive', [ 'id' => $user->id] ) }}" class="btn btn-secondary">Désactiver</a>
                <a href="{{ route('user.admin', [ 'id' => $user->id] ) }}" class="btn btn-primary">Rendre Admin</a>
                <a href="{{ route('user.delete', [ 'id' => $user->id] ) }}" class="btn btn-danger">Supprimer</a>
                
            </div>
        </div>
    </div>
    @endif
    
    
@endforeach

@endsection
