@extends('layouts.entete-pied')
@section('titre')
Rechercher une adresse
@endsection

@section('contenu')

<h1>etape 2</h1>

<form method="POST" action="{{ route('postInfo') }}">
    <!-- important, sinon l'info ne passe pas et erreur 417 -->
    @csrf <!-- {{ csrf_field() }} -->
    <div class="form-group">
        <input type="text" class="form-control" name="age-bien">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="type">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="nb-pieces">
    </div>
    <button class="btn btn-primary" type="submit">valider</button>
</form>
@endsection