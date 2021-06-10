@extends('layouts.entete-pied')
@section('titre')
Rechercher une adresse
@endsection

@section('contenu')

<h1>etape 1</h1>

<form method="POST" action="{{ route('postGeocoder') }}">
    <!-- important, sinon l'info ne passe pas et erreur 417 -->
    @csrf <!-- {{ csrf_field() }} -->
    <div class="form-group">
        <input type="text" class="form-control" name="longitude">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="latitude">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="adresse">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="cp">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="commune">
    </div>
    <button class="btn btn-primary" type="submit">valider</button>
</form>
@endsection