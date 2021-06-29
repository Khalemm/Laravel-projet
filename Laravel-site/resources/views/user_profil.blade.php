@extends('layouts.app')

@section('contenu')

@if(Session::has('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>   
        {{Session::get('success')}}
    </div>
@endif

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
                            <form method="POST" action="{{ route('user.update-profil') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Prénom') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" 
                                        pattern="[a-zA-Z]+" title="Pas de valeurs numériques" value="{{ $user->name }}" autocomplete="name" required >
                                        <script>
                                        var input = document.getElementById('name');
                                        var form  = document.getElementById('form');
                                        var elem  = document.createElement('div');
                                        elem.id = 'notify';
                                        elem.style.display = 'none';
                                        form.appendChild(elem);

                                        input.addEventListener('invalid', function(event){
                                            event.preventDefault();
                                            if ( ! event.target.validity.valid ) {
                                                elem.textContent   = 'Username should only contain lowercase letters e.g. john';
                                                elem.className     = 'error';
                                                elem.style.display = 'block';
                                        
                                                input.className    = 'invalid animated shake';
                                            }
                                            if ( 'block' === elem.style.display ) {
                                                input.className = '';
                                                elem.style.display = 'none';
                                            }
                                        });
                                        </script>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                                    <div class="col-md-6">
                                        <input id="last_name" type="text" class="form-control" name="last_name" 
                                        pattern="[a-zA-Z]+" title="Pas de valeurs numériques" value="{{ $user->last_name }}" autocomplete="last_name" required >
                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tel_fixe" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone fixe') }}</label>

                                    <div class="col-md-6">
                                        <input id="tel_fixe" type="tel" class="form-control" name="tel_fixe" pattern="[0-9]{10}" 
                                        title="Veuillez entrer 10 valeurs" maxlength="10" 
                                        value="{{ $user->tel_fixe }}" autocomplete="tel_fixe" >
                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tel_mobile" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone portable') }}</label>

                                    <div class="col-md-6">
                                        <input id="tel_mobile" type="tel" class="form-control" name="tel_mobile" pattern="[0-9]{10}" 
                                        title="Veuillez entrer 10 valeurs" maxlength="10" 
                                        value="{{ $user->tel_mobile }}" autocomplete="tel_mobile" >
                                        
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
                            <form method="POST" action="{{ route('user.update-entreprise') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="nom_entreprise" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                                    <div class="col-md-6">
                                        <input id="nom_entreprise" type="name" class="form-control" 
                                        name="nom_entreprise" value="{{ $user->nom_entreprise }}" autocomplete="nom_entreprise" >
                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="adresse_entreprise" class="col-md-4 col-form-label text-md-right">{{ __('Adresse') }}</label>

                                    <div class="col-md-6">
                                        <input id="adresse_entreprise" type="text" class="form-control" name="adresse_entreprise"
                                        value="{{ $user->adresse_entreprise }}" autocomplete="adresse_entreprise" >
                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="code_postal" class="col-md-4 col-form-label text-md-right">{{ __('Code Postal') }}</label>

                                    <div class="col-md-6">
                                        <input id="code_postal" type="text" class="form-control" maxlength="5" pattern="[0-9]{5}" 
                                        title="Veuillez entrer 5 valeurs" placeholder="75001"
                                        name="code_postal" value="{{ $user->code_postal }}" autocomplete="code_postal" >
                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="ville_entreprise" class="col-md-4 col-form-label text-md-right">{{ __('Ville') }}</label>

                                    <div class="col-md-6">
                                        <input id="ville_entreprise" type="text" class="form-control" pattern="[A-Za-z' -]+"
                                        name="ville_entreprise" value="{{ $user->ville_entreprise }}" autocomplete="ville_entreprise">
                                        
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
                                Abonnement : {{ $abonnement->nom }} {{ $abonnement->type }} <br>
                                Description : {{ $abonnement->description }} <br>
                            </p>
                            <a href="{{ route('abonnements') }}" class="btn btn-primary" role="button" data-bs-toggle="button">
                                Changer votre abonnement </a>
                            <!--<form method="POST" action="">
                                @csrf

                                <div class="form-group row">
                                    <label for="abonnement" class="col-md-4 col-form-label text-md-right">{{ __('Abonnement') }}</label>

                                    <div class="col-md-6">
                                        <input id="abonnement" type="abonnement" class="form-control" name="abonnement" 
                                        value="{{ $abonnement->nom }}" autocomplete="abonnement" readonly>
                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="prenom" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                    <div class="col-md-6">
                                        <input id="abonnement" type="abonnement" class="form-control" name="abonnement" 
                                        value="{{ $abonnement->description }}" autocomplete="abonnement" readonly>
                                        
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Changer votre abonnement') }}
                                        </button>
                                    </div>
                                </div>
                            </form>-->
                            
                        </div>
                    
                    </div>
                    <!---------------------------- sécurité / changer mdp ------------------------------>
                    <div class="tab-pane fade" id="param" role="tabpanel" aria-labelledby="param-tab">
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.profil', ['id' => Auth::user()->id]) }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Mail') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="text" class="form-control" name="email" 
                                         value="{{ $user->email }}" autocomplete="email" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe actuel') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Nouveau mot de passe') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
