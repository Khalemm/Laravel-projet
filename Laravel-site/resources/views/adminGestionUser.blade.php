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
<ul><li><a href="{{ route('user.non-confirme' ) }}" onclick="return confirm('Confirmer la suppression des utilisateurs')" 
class="btn btn-danger">Supprimer les utilisateurs non vérifiés</a></li></ul>
<hr>
<div class="row margin-fix">
    @foreach ($users as $user)
        @if ($user->admin == false)
        <div class="liste-users d-flex ">
            @if ($user->email_verified_at == null)
            <div class="popup card liste noemail">
            @else
            <div class="popup card liste">
            @endif
                <div class="haut-de-carte-liste card-header">
                    <div class="texte-header-liste">
                        <p>Créé le {{ $user->created_at->format('d/m/Y') }}</p>
                        <p>Nom : {{$user->name}}</p>
                        <p>Prenom : {{$user->last_name}}</p>
                        <p>E-mail : {{$user->email}}</p>
                        <p>Entreprise : {{$user->nom_entreprise}}</p>
                        <p>Telephone : {{$user->tel_mobile}}</p>
                        <p>Abonnement : 
                        @if ($user->abonnement ) 
                        Oui du {{ date_format(new DateTime($user->date_abonnement), 'd/m/Y') }} au {{ date_format(new DateTime($user->date_fin_abonnement), 'd/m/Y') }}
                        @else Non
                        @endif
                        </p>
                        @include('admin_script')
                        @if ($user->active)
                        <form method="POST" action="{{ route('user.abonnement', [ 'id' => $user->id]) }}">
                            @csrf
                            <div class="d-flex">
                            <div class="info-abonnement">
                                <div class="champ-abo-admin input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ __('Début :') }}</span>
                                    </div>
                                    <label for="name"></label>
                                    <input class="form-control" id="date_abonnement" type="date" name="date_abonnement" 
                                        value="{{ date_format(new DateTime($user->date_abonnement), 'Y-m-d') }}">
                                </div>
                                <div class="champ-abo-admin input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ __('Fin :') }}</span>
                                    </div>
                                    <input class="form-control" id="date_fin_abonnement" type="date" name="date_fin_abonnement" 
                                        min="{{ date_format(new DateTime($user->date_abonnement), 'Y-m-d') }}" 
                                        value="{{ date_format(new DateTime($user->date_fin_abonnement), 'Y-m-d') }}">
                                </div>
                            </div>
                            <div class="btn-abonnement">
                                @if (!$user->abonnement)
                                    <button type="submit" class="btn btn-secondary" >{{ __('Ajouter') }}</button>
                                @else
                                    <button type="submit" class="btn btn-secondary" >{{ __('Modifier') }}</button>
                                    <a href="{{ route('user.delete-abonnement', [ 'id' => $user->id] ) }}" class="btn btn-danger" >Supprimer</a>
                                @endif
                            </div>
                            </div>
                        </form>
                        @endif
                        
                    </div>
                </div>
                <div class="boutons-carte card-body">
                @if ($user->active)
                    <a href="{{ route('user.desactive', [ 'id' => $user->id] ) }}" class="btn btn-secondary">Désactiver</a>
                @else 
                    @if ($user->email_verified_at != null)
                    <a href="{{ route('user.active', [ 'id' => $user->id] ) }}" class="btn btn-success">Activer</a>
                    @endif

                @endif

                @if ($user->active)
                    <a href="{{ route('user.admin', [ 'id' => $user->id] ) }}" class="btn btn-primary">Rendre Admin</a>
                @endif
                    <a href="{{ route('user.delete', [ 'id' => $user->id] ) }}" onclick="return confirm('Confirmer la suppression de l`utilisateur')" class="btn btn-danger">Supprimer</a>
                
                </div>
            </div>
        </div>
        @endif
    @endforeach
</div>

@endsection
