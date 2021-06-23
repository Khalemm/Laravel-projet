<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requete;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class requeteMapController extends Controller { // Controller pour la recherche d'une maison

    public function __construct()
    {
        $this->middleware('auth'); //faut se connecter pour avoir accès
    }

    public function geocoder() {
        $erreur = null;
        return view('rechercheBienGeocoder', ['erreur' => $erreur]);
    }

    public function postGeocoder(Request $requete) {
        
        $longitude = $requete->input(['longitude']);
        $latitude = $requete->input(['latitude']);
        $adresse = $requete->input(['adresse']);
        $code_postal = $requete->input(['code_postal']);
        $nom_commune = $requete->input(['nom_commune']);
        //vérifie si le code postal rentré est juste
        if(preg_match("/([0-9]){5}/i",$code_postal) == 0) {
            $erreur = "Vérifiez que vous avez bien saisi une adresse postale existante (aidez-vous des propositions fournies).";
            return view('rechercheBienGeocoder', ['erreur' => $erreur]);
        }
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

        if ($requete['prix_min'] == null && $requete['prix_max'] == null) //prix min et prix max facultatifs
        {
            $requete['prix_min'] = 0;
            $requete['prix_max'] = 600000000;
        }
        //on recupere les parametres du second formulaire pour effectuer la requete a la BDD
        $requete_user = Requete::firstOrCreate([
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
        //si jamais une erreur insoupconné arrive, on fait ici un try/catch
        try{
            //requete avec les paramètres pour avoir la liste des 25 biens 
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
                    AND valeur_fonciere BETWEEN :prix_min and :prix_max
                ORDER BY ST_Distance(geom, ref_geom) LIMIT 25",

                ['longitude' => $requete['longitude'],
                'latitude' => $requete['latitude'],
                'code_postal' => $requete['code_postal'],
                //'distance' => $distance,
                'nature_mutation' => $requete['nature_mutation'],
                'type_local' => $requete['type_local'],
                'nombre_pieces_principales' => $requete['nombre_pieces_principales'],
                'prix_min' => $requete['prix_min'],
                'prix_max' => $requete['prix_max'] ]
            );

            //vérifie si la requête n'est pas vide
            if($resultat == []) {
                $erreur = "Il se pourrait qu'aucun bien n'ait été vendu aux alentours de l'adresse fournie.";
                return view('rechercheBienGeocoder', ['erreur' => $erreur]);
            }
            
            session(['res' => $resultat]); 
            session(['req' => [
                'longitude' => $requete['longitude'], 
                'latitude' => $requete['latitude'], 
                'adresse' => $requete['adresse']
            ]]);
            return view('map');
        } catch(\Exception $e) {
            $erreur = "essayez de rentrer une autre adresse.";
            return view('rechercheBienGeocoder', ['erreur' => $erreur]);
        }
    }

    //quand l'utilisateur veut voir sa requete à partir de sa liste de requetes
    public function voirRequete($req_id)
    {
        $requete = DB::table('requetes')->find($req_id); //on cherche dans la BDD sa requete

        $type_bien = $requete->type_bien; //on recupère les parametres 
        $nature_mutation = $requete->age_bien;
        $nb_pieces = $requete->nombre_pieces;
        $prix_min = $requete->prix_min;
        $prix_max = $requete->prix_max;
        
        $code_postal = $requete->code_postal;
        $adresse = $requete->adresse;
        $longitude = $requete->longitude;
        $latitude = $requete->latitude;

        //requete avec les paramètres pour avoir la liste de biens 
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
                AND valeur_fonciere BETWEEN :prix_min and :prix_max
            ORDER BY ST_Distance(geom, ref_geom) LIMIT 25",

            ['longitude' => $longitude,
            'latitude' => $latitude,
            'code_postal' => $code_postal,
            'nature_mutation' => $nature_mutation,
            'type_local' => $type_bien,
            'nombre_pieces_principales' => $nb_pieces,
            'prix_min' => $prix_min,
            'prix_max' => $prix_max ]
        );

        session(['res' => $resultat]); 
        session(['req' => [
            'longitude' => $requete->longitude, 
            'latitude' => $requete->latitude, 
            'adresse' => $requete->adresse
        ]]);
        return view('map');
    }

    public function supprimerRequete($reqid) //l'utilisateur supprime une requete
    {
        $requete = Requete::find($reqid) ;
        $requete->delete();

        //$request->session()->flash('success','Requete supprimée');

        return redirect()->back()->with('info',"Votre requete a été supprimée");
    }

    function change_format($value)
    {
        return preg_replace('/(?<=\d)(?=(\d{3})+$)/', ' ', $value);
    }
}
