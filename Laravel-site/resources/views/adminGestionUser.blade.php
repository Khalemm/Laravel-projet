@extends('layouts.app')

@section('titre')
Administration    
@endsection

@section('contenu')

@if(Session::has('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>    
        {{Session::get('success')}}
    </div>
@endif

@if(Session::has('info'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>   
        {{Session::get('info')}}
    </div>
@endif

<br>
<ul><li><a href="{{ route('user.non-confirme' ) }}" onclick="return confirm('Confirmer la suppression des utilisateurs')" class="btn btn-danger">Supprimer les utilisateurs non confirmés</a></li></ul>
<hr>
<div class="row margin-fix">
    @foreach ($users as $user)
        @if ($user->admin == false)
        <div class="liste-users">
            @if ($user->email_verified_at == null)
            <div class="popup card liste noemail">
            @else
            <div class="popup card liste">
            @endif
                <div class="haut-de-carte card-header">
                    <div class="texte-header">
                        <p>Créé le {{date_format($user->created_at, 'd/m/y à H:i')}}</p>
                        <p>Nom : {{$user->name}}</p>
                        <p>Prenom : {{$user->last_name}}</p>
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
                    
                    <a href="{{ route('user.admin', [ 'id' => $user->id] ) }}" class="btn btn-primary">Rendre Admin</a>
                    <a href="{{ route('user.delete', [ 'id' => $user->id] ) }}" onclick="return confirm('Confirmer la suppression de l`utilisateur')" class="btn btn-danger">Supprimer</a>
                    
                </div>
            </div>
        </div>
        @endif
    @endforeach
</div>

@endsection
