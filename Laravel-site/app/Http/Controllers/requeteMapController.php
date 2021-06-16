<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requete;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

class requeteMapController extends Controller {
    // Controller pour la recherche d'une maison

    public function geocoder() {
        return view('rechercheBienGeocoder');
    }

    public function postGeocoder(Request $requete) {
        
        //session(['clé' => $requete->only(['longitude', 'latitude', 'adresse', 'code_postal', 'nom_commune'])]);
        
        $longitude = $requete->input(['longitude']);
        $latitude = $requete->input(['latitude']);
        $adresse = $requete->input(['adresse']);
        $code_postal = $requete->input(['code_postal']);
        $nom_commune = $requete->input(['nom_commune']);

        //on recupere les parametres de résultat de la première partie du formulaire pour créer la requete
        session([
            'clé' => [
                'longitude' => $longitude, 
                'latitude' => $latitude, 
                'adresse' => $adresse, 
                'code_postal' => $code_postal, 
                'nom_commune' => $nom_commune
            ]
        ]); 

        return view('rechercheBienDetail');
    }

    public function postInformationsComplementaires(Request $requete) { 
        $requete->merge( session('clé' ) );
        $id_user = Auth::id(); //id de l'utilisateur

        //on recupere les parametres du second formulaire pour effectuer la requete a la BDD
        $requete_user = Requete::create([
            'age_bien' => $requete['nature_mutation'], 
            'type_bien' => $requete['type_local'], 
            'nombre_pieces' => $requete['nombre_pieces_principales'], 
            'prix_min' => $requete['prix_min'], 
            'prix_max' => $requete['prix_max'],
            'user_id' => $id_user, 
            'longitude' => $requete['longitude'], 
            'latitude' => $requete['latitude'],
            'adresse' => $requete['adresse'], 
            'code_postal' => $requete['code_postal'], 
            'nom_commune' => $requete['nom_commune'] 
        ]); 

        //LA REQUETE (corriger les IN et renvoyer le résultat en geojson) distance??
        $resultat = DB::select("SELECT id_mutation , date_mutation, annee_mutation, nature_mutation, valeur_fonciere,
            CONCAT(adresse_numero, adresse_suffixe, ' ', adresse_nom_voie) as adresse,
            code_postal, code_commune, nom_commune, id_parcelle,  type_local, 
            surface_reelle_bati, nombre_pieces_principales, surface_terrain, 
            z_prixm2, geom, ROUND(ST_Distance(geom, ref_geom)) AS distance, latitude, longitude  
            FROM dvfneocy CROSS JOIN (SELECT ST_MakePoint(:longitude,:latitude)::geography AS ref_geom) AS r  
            WHERE 
                code_postal = :code_postal
                AND nature_mutation = :nature_mutation
                AND type_local = :type_local 
                AND nombre_pieces_principales = :nombre_pieces_principales  
                AND ST_DWithin(geom, ref_geom, 500)
            ORDER BY ST_Distance(geom, ref_geom) LIMIT 25",

            ['longitude' => $requete['longitude'],
            'latitude' => $requete['latitude'],
            'code_postal' => $requete['code_postal'],
            //'distance' => $distance,
            'nature_mutation' => $requete['nature_mutation'],
            'type_local' => $requete['type_local'],
            'nombre_pieces_principales' => $requete['nombre_pieces_principales'] ]
        );

        session(['res' => $resultat]); 
        session(['req' => [
            'longitude' => $requete['longitude'], 
            'latitude' => $requete['latitude'], 
            'adresse' => $requete['adresse']
        ]]);
        return view('map');
    }

    public function modifierRequete($id)
    {
        $lien = Requete::findOrFail($id) ;
    }

    public function supprimerRequete($id)
    {
        $lien = Requete::findOrFail($id) ;
    }

    function change_format($value)
    {
        return preg_replace('/(?<=\d)(?=(\d{3})+$)/', ' ', $value);
    }
}

//arreglar requete (IN, between prix y cuando es empty) !, affichage liste requetes !, arreglar form, requete pour guest
//faire les IN avec un array
//quand y a rien cambiar en not null