@extends('layouts.app')

@extends('user_profil_ajax')

@section('contenu')

<div class="alert"></div>

@if(Session::has('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>    
        {{Session::get('success')}}
    </div>
@endif

<!--@if(Session::has('error'))
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert">×</button>   
        {{Session::get('error')}}
    </div>
@endif-->

<main class="py-4">
    @yield('content')
</main>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" role="tab" aria-current="page" href="#profil" data-toggle="tab">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab" aria-current="page" href="#ent" data-toggle="tab">Entreprise</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab" aria-current="page" href="#abonnement" data-toggle="tab">Abonnement</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab" aria-current="page" href="#param" data-toggle="tab">Paramètres</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                <!---------------------------------------- formulaire profil-------------------------------------->
                    <div class="tab-pane fade show active" id="profil" role="tabpanel" aria-labelledby="profil-tab">
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.update-profil') }}"  id="updateProfil">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Prénom') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" 
                                        value="{{ $user->name }}" autocomplete="name" >
                                        <span class="text-danger error-text name_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                                    <div class="col-md-6">
                                        <input id="last_name" type="text" class="form-control" name="last_name" 
                                        value="{{ $user->last_name }}" autocomplete="last_name" >
                                        <span class="text-danger error-text last_name_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tel_fixe" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone fixe') }}</label>

                                    <div class="col-md-6">
                                        <input id="tel_fixe" type="tel" class="form-control" name="tel_fixe" maxlength="10" 
                                        value="{{ $user->tel_fixe }}" autocomplete="tel_fixe" >
                                        <span class="text-danger error-text tel_fixe_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tel_mobile" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone portable') }}</label>

                                    <div class="col-md-6">
                                        <input id="tel_mobile" type="tel" class="form-control" name="tel_mobile" maxlength="10" 
                                        value="{{ $user->tel_mobile }}" autocomplete="tel_mobile" >
                                        <span class="text-danger error-text tel_mobile_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Sauvegarder') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="ent" role="tabpanel" aria-labelledby="ent-tab">
                    <!------------------------------- formulaire infos entreprise ---------------------------------->
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.update-entreprise') }}" id="updateEntreprise">
                                @csrf

                                <div class="form-group row">
                                    <label for="nom_entreprise" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                                    <div class="col-md-6">
                                        <input id="nom_entreprise" type="name" class="form-control" 
                                        name="nom_entreprise" value="{{ $user->nom_entreprise }}" autocomplete="nom_entreprise" >
                                        <span class="text-danger error-text nom_entreprise_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="adresse_entreprise" class="col-md-4 col-form-label text-md-right">{{ __('Adresse') }}</label>

                                    <div class="col-md-6">
                                        <input id="adresse_entreprise" type="text" class="form-control" name="adresse_entreprise"
                                        value="{{ $user->adresse_entreprise }}" autocomplete="adresse_entreprise" >
                                        <span class="text-danger error-text adresse_entreprise_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="code_postal" class="col-md-4 col-form-label text-md-right">{{ __('Code Postal') }}</label>

                                    <div class="col-md-6">
                                        <input id="code_postal" type="text" class="form-control" maxlength="5" placeholder="75001"
                                        name="code_postal" value="{{ $user->code_postal }}" autocomplete="code_postal" >
                                        <span class="text-danger error-text code_postal_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="ville_entreprise" class="col-md-4 col-form-label text-md-right">{{ __('Ville') }}</label>

                                    <div class="col-md-6">
                                        <input id="ville_entreprise" type="text" class="form-control" pattern="[A-Za-z' -]+"
                                        name="ville_entreprise" value="{{ $user->ville_entreprise }}" autocomplete="ville_entreprise">
                                        <span class="text-danger error-text ville_entreprise_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Sauvegarder') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    
                    </div>
                    <!---------------------------------------- abonnement --------------------------------------->
                    <div class="tab-pane fade" id="abonnement" role="tabpanel" aria-labelledby="abonnement-tab">
                        <div class="card-body">
                            <p class="card-text" >
                                Abonnement : 
                                @if ($user->abonnement)
                                Oui <br>
                                Date début : {{ date_format(new DateTime($user->date_abonnement), 'd/m/y')}} <br>
                                Date de fin : {{ date_format(new DateTime($user->date_fin_abonnement), 'd/m/y')}} <br>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <a href="{{ route('user.stop-abonnement') }}" class="btn btn-danger" role="button" data-bs-toggle="button">
                                        Arreter votre abonnement </a>
                                    </div>
                                </div>   
                                @else
                                <form method="POST" action="{{ route('user.update-abonnement') }}">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="oui" id="oui" value="option1">
                                            <label class="form-check-label" for="inlineRadio1">oui</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="non" id="non" value="option2" checked>
                                            <label class="form-check-label" for="inlineRadio2">non</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Mensuel ou annuel<span class="text-danger">*</span></label>
                                        <select name="date_fin_abonnement" id="date_fin_abonnement" class="form-control form_data">
                                            <option value="mensuel">Mensuel</option>
                                            <option value="annuel">Annuel</option>
                                        </select>
                                        <span id="type_local_error" class="text-danger"></span>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-success">
                                                {{ __('Commencer') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @endif 
                            </p>
                        </div>
                    
                    </div>
                    <!---------------------------- sécurité / changer mdp ------------------------------>
                    
                    <div class="tab-pane fade" id="param" role="tabpanel" aria-labelledby="param-tab">
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.update-mdp') }}" id="changePassword">
                                @csrf
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Mail') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="text" class="form-control" name="email" 
                                         value="{{ $user->email }}" autocomplete="email" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="oldpassword" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe actuel') }}</label>

                                    <div class="col-md-6">
                                        <input id="oldpassword" type="password" class="form-control @error('oldpassword') is-invalid @enderror" name="oldpassword" required autocomplete="oldpassword">
                                        <span class="text-danger error-text oldpassword_error"></span>
                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="newpassword" class="col-md-4 col-form-label text-md-right">{{ __('Nouveau mot de passe') }}</label>

                                    <div class="col-md-6">
                                        <input id="newpassword" type="password" class="form-control @error('password') is-invalid @enderror" 
                                        name="newpassword" required autocomplete="newpassword">
                                        <span class="text-danger error-text newpassword_error"></span>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmer votre mot de passe') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password-confirm" required autocomplete="newpassword">
                                        <span class="text-danger error-text password-confirm_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Sauvegarder') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
