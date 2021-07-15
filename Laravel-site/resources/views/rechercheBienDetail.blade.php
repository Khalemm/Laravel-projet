@extends('layouts.app')
@section('titre')
Rechercher une adresse
@endsection

@section('contenu')
<div class="form-exterieur-bg">
    <div class="justify-content-center form-size">
        <div class="etape-form">
            <h1>Etape 2</h1>
        </div>
    
        <div class="formulaire">
            <form method="POST" action="{{ route('postInfo') }}">
                <!-- important, sinon l'info ne passe pas et erreur 417 -->
                @csrf <!-- {{ csrf_field() }} -->
                <div class="form-group">
                    <label>Ancien ou VEFA<span class="text-danger">*</span></label>
                    <select name="nature_mutation" id="nature_mutation" class="form-control form_data">
                        <option value="Vente">Ancien</option>
                        <option value="Vefa">Vente en Etat Futur d'Achèvement</option>
                    </select>
                    <span id="type_local_error" class="text-danger"></span>
                </div>

                <div class="form-group">
                    <label>Type de bien <span class="text-danger">*</span></label>
                    <select name="type_local" id="type_local" class="form-control form_data">
                        <option value="Appartement">Appartement</option>
                        <option value="Maison">Maison</option>
                    </select>
                    <span id="type_local_error" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label>Nombre de pièces <span class="text-danger">*</span></label>
                    <select name="nombre_pieces_principales" id="nombre_pieces_principales" class="form-control form_data">
                        <option value="1">1 Pièce</option>
                        <option value="2">2 Pièces</option>
                        <option value="3">3 Pièces</option>
                        <option value="4">4 Pièces</option>
                        <option value="5">5 Pièces et plus</option>
                    </select>
                    <span id="nombre_pieces_principales_error" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label>Prix min</label>
                    <input type="number" name="prix_min" id="prix_min" placeholder="0" class="form-control form_data" />
                    <span id="prix_min_error" class="text-danger"></span>
                </div>

                <div class="form-group">
                    <label>Prix max</label>
                    <input type="number" name="prix_max" id="prix_max" placeholder="600000000" class="form-control form_data" />
                    <span id="prix_max_error" class="text-danger"></span>
                </div>
                <button class="btn btn-primary" type="submit">Valider</button>
            </form>
        </div>
    </div>
</div>
@endsection