@extends('layouts.entete-pied')
@section('titre')
Rechercher une adresse
@endsection
@section('contenu')

<div class="container">
    <h2 class="text-center mt-4 mb-2">Comparaison Maison ou Appartement</h2>
    
    <span id="message"></span>

    <form action="ma-compare.php" method="get" id="ma-compare-form">
           <div class="card">
            <div class="card-header">Formulaire de comparaison</div>
            <div class="card-body">

                <label>Chercher une adresse<span class="text-danger">*</span></label>
                <div id="geocoder" class="geocoder"></div><br>

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

                <div class="form-group">
                    <label>Latitude</label>
                    <input type="text" name="latitude" readonly="readonly" id="latitude" class="form-control form_data" />
                    <span id="latitude_error" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label>Longitude</label>
                    <input type="text" name="longitude" readonly="readonly" id="longitude" class="form-control form_data" />
                    <span id="latitude_error" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label>Adresse</label>
                    <input type="text" name="adresse" readonly="readonly" id="adresse" class="form-control form_data" />
                    <span id="adresse_error" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label>Code Postal</label>
                    <input type="text" name="code_postal" readonly="readonly" id="code_postal" class="form-control form_data" />
                    <span id="code_postal_error" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label>Commune</label>
                    <input type="text" name="nom_commune" readonly="readonly" id="nom_commune" class="form-control form_data" />
                    <span id="nom_commune_error" class="text-danger"></span>
                </div>


             
            </div>
            <div class="card-footer">
                <input type="submit" value="Comparer"/>
            </div>
        </div>
    </form>
</div>

@endsection