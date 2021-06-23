@extends('layouts.app')

@section('contenu')
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('Un lien de vérification vous a été envoyé par mail.') }}
                            </div>
                        @endif

                        {{ __('Veuillez vérifier vos e-mail et cliquer sur le lien de validation.') }}
                        {{ __('Si vous n\'avez pas reçu de mail') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Cliquez ici pour en recevoir un nouveau') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
