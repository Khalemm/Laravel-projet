@extends('layouts.app')

@section('titre')
Administration    
@endsection

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
<div class="row margin-fix">
    @foreach ($users as $user)
        @if ($user->admin == false)
        <div class="liste-users">
            <div class="popup card liste">
                <div class="haut-de-carte card-header">
                    <div class="texte-header">
                        <p>{{$user->name}} {{$user->last_name}}</p>
                        <p>E-mail : {{$user->email}}</p>
                        <p>Entreprise : {{$user->nom_entreprise}}</p>
                        <p>Telephone : {{$user->tel_mobile}}</p>
                    </div>
                </div>
                <div class="millieu-de-carte card-body">
                    @if ($user->active)
                        <a href="{{ route('user.desactive', [ 'id' => $user->id] ) }}" class="btn btn-secondary">Désactiver</a>
                    @else
                        <a href="{{ route('user.active', [ 'id' => $user->id] ) }}" class="btn btn-success">Activer</a>
                    @endif
                    
                    <a href="{{ route('user.admin', [ 'id' => $user->id] ) }}" class="btn btn-warning">Rendre Admin</a>
                    <a href="{{ route('user.delete', [ 'id' => $user->id] ) }}" class="btn btn-danger">Supprimer</a>
                    
                </div>
            </div>
        </div>
        @endif
    @endforeach
</div>

@endsection
