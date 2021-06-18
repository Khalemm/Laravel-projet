@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" role="tab" aria-current="page" href="#profile" data-toggle="tab">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab" aria-current="page" href="#ent" data-toggle="tab">Entreprise</a>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link" role="tab" aria-current="page" href="#contact" data-toggle="tab">Changer mot de passe ?</a>
                    </li>-->
                </ul>
                <div class="tab-content" id="myTabContent">
                <!-- formulaire profil-->
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.update-profil') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Prénom') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                                    <div class="col-md-6">
                                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}" autocomplete="last_name" autofocus>

                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tel_fixe" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone fixe') }}</label>

                                    <div class="col-md-6">
                                        <input id="tel_fixe" type="number" class="form-control" name="tel_fixe" value="{{ $user->tel_fixe }}" autocomplete="tel_fixe" autofocus>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tel_mobile" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone portable') }}</label>

                                    <div class="col-md-6">
                                        <input id="tel_mobile" type="number" class="form-control" name="tel_mobile" value="{{ $user->tel_mobile }}" autocomplete="tel_mobile" autofocus>
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
                    <!-- formulaire infos entreprise -->
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.update-entreprise') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="nom_entreprise" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                                    <div class="col-md-6">
                                        <input id="nom_entreprise" type="name" class="form-control @error('nom_entreprise') is-invalid @enderror" name="nom_entreprise" value="{{ $user->nom_entreprise }}" autocomplete="nom_entreprise" autofocus>

                                        @error('nom_entreprise')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="adresse_entreprise" class="col-md-4 col-form-label text-md-right">{{ __('Adresse') }}</label>

                                    <div class="col-md-6">
                                        <input id="adresse_entreprise" type="text" class="form-control @error('adresse_entreprise') is-invalid @enderror" name="adresse_entreprise" value="{{ $user->adresse_entreprise }}" autocomplete="adresse_entreprise" autofocus>

                                        @error('adresse_entreprise')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="code_postal" class="col-md-4 col-form-label text-md-right">{{ __('Code Postal') }}</label>

                                    <div class="col-md-6">
                                        <input id="code_postal" type="number" class="form-control @error('code_postal') is-invalid @enderror" name="code_postal" value="{{ $user->code_postal }}" autocomplete="code_postal" autofocus>

                                        @error('code_postal')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="ville_entreprise" class="col-md-4 col-form-label text-md-right">{{ __('Ville') }}</label>

                                    <div class="col-md-6">
                                        <input id="ville_entreprise" type="text" class="form-control @error('ville_entreprise') is-invalid @enderror" name="ville_entreprise" value="{{ $user->ville_entreprise }}" autocomplete="ville_entreprise" autofocus>

                                        @error('ville_entreprise')
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
                    <!-- sécurité / changer mdp -->
                    <!--<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">hehe
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.profil', ['id' => Auth::user()->id]) }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="prenom" class="col-md-4 col-form-label text-md-right">{{ __('Prénom') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                                    <div class="col-md-6">
                                        <input id="last_name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tel_fixe" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone fixe') }}</label>

                                    <div class="col-md-6">
                                        <input id="last_name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tel_mobile" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone portable') }}</label>

                                    <div class="col-md-6">
                                        <input id="last_name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                        @error('last_name')
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
                    
                    </div>-->
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
