@extends('layouts.app')
@section('titre')
Accueil
@endsection

@section('scripts')
@endsection

@section('contenu')

@if (!Auth::guest() && !Auth::user()->active)
    @if (Auth::user()->email_verified_at == null)
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>  
            <h4 class="alert-heading">Merci pour votre inscription !</h4>
            <p>Pour finaliser la création de votre compte, veuillez consulter votre boite de réception et cliquez sur le lien 
            que nous vous avons envoyé par mail. En cliquant sur ce lien, vous validez votre compte.</p>
            <hr>
            
            <a href="{{ route('verification.send') }}" style="text-decoration: underline;">Je n'ai pas reçu le mail. Me renvoyer un mail</a>
        </div>

        @if(Session::has('info'))
            <div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                {{Session::get('info')}}
            </div>
        @endif

    @else
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>   
            Votre compte a bien été créé, il sera activé prochainement.
        </div>
    @endif
@endif

<div class="accueil-bloc">
    <div class="presentation-bloc">
        <div class="interieur-presentation-bloc">
            <div class="titre-presentation">
                <h2>Estimez le prix des biens !</h2>
            </div>
            <div class="contenu-presentation">
                <p> Ici vous pourrez estimer le prix des biens près de chez vous </p>
                <a class="btn btn-primary" href="/recherche"> Faire une nouvelle évaluation</a>
                </div>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection

@section('scripts-pied')
@endsection