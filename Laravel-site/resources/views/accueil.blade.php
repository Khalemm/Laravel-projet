@extends('layouts.app')
@section('titre')
Accueil
@endsection

@section('scripts')
@endsection

@section('contenu')
@if (!Auth::guest() && !Auth::user()->active)
    @include('registered')
@endif
<div class="accueil-bloc">
    <div class="presentation-bloc">
        <div class="interieur-presentation-bloc">
            <div class="titre-presentation">
                <h2>Estimez le prix des biens !</h2>
            </div>
            <div class="contenu-presentation">
                <p> Ici vous pourrez estimer le prix des biens près de chez vous </p>
                <p> texte de remplissage </p>
                <p> je sais pas quoi mettre encore ici ;_;</p>
                <p> Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ullam, voluptate ipsum corporis suscipit voluptates repellat obcaecati molestias fuga praesentium dolore quos, aperiam perspiciatis voluptatem magnam nam minima placeat. Reprehenderit, eum?</p>
            </div>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection

@section('scripts-pied')
@endsection