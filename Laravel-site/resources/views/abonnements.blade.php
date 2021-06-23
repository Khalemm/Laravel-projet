@extends('layouts.app')
@section('titre')
Abonnements
@endsection
@section('contenu')

@if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>
@endif

<br>
<h1>Liste d'abonnements :</h1>
<hr>
    @if ($abonnements->count() > 0)
        <div class="row row-cols-1 row-cols-md-3 g-4" style="margin-left: 0.8rem; text-align: center;">
        @foreach($abonnements as $abonnement)
        <div class="col">
            <div class="card "> <!-- card h-75 -->
                <!--<img src="..." class="card-img-top" alt="...">-->
                <div class="card-body">
                    <h5 class="card-title">{{ $abonnement->nom }}</h5>
                    <p class="card-text">
                    {{ $abonnement->type }}<br>
                    {{ $abonnement->prix }}<br>
                    {{ $abonnement->description }}
                    </p>
                </div>
                <div class="card-footer">
                    @if ( $abonnement->id == Auth::user()->abonnement)
                    <a href="{{ route('user.update-abonnement', [ 'id' => $abonnement->id] ) }}" class="btn btn-primary btn disabled" style="margin-right:15px;">Choisir</a>
                    @else
                    <a href="{{ route('user.update-abonnement', [ 'id' => $abonnement->id] ) }}" class="btn btn-outline-primary" style="margin-right:15px;">Choisir</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        </div>
    @else
        <span>Aucun abonnement en base de données</span>
    @endif

@endsection