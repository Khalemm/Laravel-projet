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
        <label>Ancien ou VEFA<span class="text-danger">*</span></label>
        <select name="nature_mutation" id="nature_mutation" class="form-control form_data">
            <option value="">Choix age du bien</option>
            <option value="Vente">Ancien</option>
            <option value="Vefa">Vente en Etat Futur d'Achèvement</option>
        </select>
        <span id="type_local_error" class="text-danger"></span>
    </div>

    <div class="form-group">
        <label>Type de bien <span class="text-danger">*</span></label>
        <select name="type_local" id="type_local" class="form-control form_data">
            <option value="">Choix du type de bien</option>
            <option value="Appartement">Appartement</option>
            <option value="Maison">Maison</option>
        </select>
        <span id="type_local_error" class="text-danger"></span>
    </div>

    <div class="form-group">
        <label>Nombre de pièces <span class="text-danger">*</span></label>
        <select name="nombre_pieces_principales" id="nombre_pieces_principales" class="form-control form_data">
            <option value="">Choix du nombre de pièces</option>
            <option value="1">1 Pièce</option>
            <option value="2">2 Pièces</option>
            <option value="3">3 Pièces</option>
            <option value="4">4 Pièces</option>
            <option value="5">5 Pièces et plus</option>
        </select>
        <span id="nombre_pieces_principales_error" class="text-danger"></span>
    </div>
    <button class="btn btn-primary" type="submit">valider</button>
</form>
@endsection