@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" role="tab" aria-current="page" href="#home" data-toggle="tab">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab" aria-current="page" href="#profile" data-toggle="tab">Entreprise</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab" aria-current="page" href="#contact" data-toggle="tab">Changer mot de passe ?</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                <!-- formulaire profil-->
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">hello
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.update-profil') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Prénom') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" autocomplete="name" autofocus>

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
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">dada
                    <!-- formulaire infos entreprise -->
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.profil', ['id' => Auth::user()->id]) }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="prenom" class="col-md-4 col-form-label text-md-right">{{ __('Prénom') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

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
                                        <input id="last_name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name" value="{{ $user->name }}" required autocomplete="last_name" autofocus>

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
                                        <input id="last_name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name" value="{{ $user->name }}" required autocomplete="last_name" autofocus>

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
                                        <input id="last_name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name" value="{{ $user->name }}" required autocomplete="last_name" autofocus>

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
                    
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">hehe
                    <!-- sécurité / changer mdp -->
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
                    
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
