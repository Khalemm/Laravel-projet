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

        //quand l'utilisateur n'a pas mis de prix, on leur associe une valeur pour faire la requete
        if ($requete['prix_min'] == null) //prix min facultatif
        {
            $requete['prix_min'] = 0;
        }

        if ($requete['prix_max'] == null) //prix max facultatif
        {
            $requete['prix_max'] = 600000000;
        }
        
        //si jamais une erreur insoupconné arrive, on fait ici un try/catch
        try{
            //requete pour trouver les infos de la commune
            $commune = DB::select("SELECT code_commune, code_postal, nom_commune, population
            FROM communes
            WHERE 
                code_postal = :code_postal",

            [ 'code_postal' => $requete['code_postal'] ] //en paramètre le code postal venant du geocoder
            );
            $code_commune = $commune[0]->code_commune; //$commune est un array, on extrait le code commune
            
            //on compte nombre de lignes de la requete
            $count_commune = count((array)$commune);

            //si y a plus d'une ligne, ça signifie qu'un code postal appartient à plusieurs communes
            //donc on refait la requete avec cp et nom commune en paramètre
            if($count_commune > 1)
            {
                $commune_exacte = DB::select("SELECT code_commune, code_postal, nom_commune, population
                FROM communes
                WHERE 
                    nom_commune LIKE :nom_commune
                    AND code_postal = :code_postal",

                [ 'nom_commune' => '%'.$requete['nom_commune'].'%', 
                'code_postal' => $requete['code_postal'] ] //en paramètre le code postal et le nom commune venant du geocoder
                );

                $code_commune = $commune_exacte[0]->code_commune; //on extrait le code commune
                $commune = $commune_exacte; 
            }

            //requete lorsque l'utilisateur souhaite voir des biens avec 5 pièces et plus
            if($requete['nombre_pieces_principales'] == 5)
            {
                $resultat_plus_de_5_pieces = DB::select("SELECT id_mutation , date_mutation, annee_mutation, nature_mutation, valeur_fonciere,
                CONCAT(adresse_numero, adresse_suffixe, ' ', adresse_nom_voie) as adresse,
                code_postal, code_commune, nom_commune, id_parcelle,  type_local, 
                surface_reelle_bati, nombre_pieces_principales, surface_terrain, 
                z_prixm2, geom, ROUND(ST_Distance(geom, ref_geom)) AS distance, latitude, longitude  
                FROM dvfneocy CROSS JOIN (SELECT ST_MakePoint(:longitude,:latitude)::geography AS ref_geom) AS r  
                WHERE 
                    code_commune = :code_commune
                    AND nature_mutation = :nature_mutation
                    AND type_local = :type_local 
                    AND nombre_pieces_principales IN (5,6,7,8,9,10) /*nombre de pièces*/
                    AND ST_DWithin(geom, ref_geom, 2500)
                    AND valeur_fonciere BETWEEN :prix_min and :prix_max
                ORDER BY ST_Distance(geom, ref_geom) LIMIT 25",

                ['longitude' => $requete['longitude'],
                'latitude' => $requete['latitude'],
                'code_commune' => $code_commune,
                'nature_mutation' => $requete['nature_mutation'],
                'type_local' => $requete['type_local'],
                'prix_min' => $requete['prix_min'],
                'prix_max' => $requete['prix_max'] ]
                );
                $resultat = $resultat_plus_de_5_pieces;
            }
            else{
            //requete avec les paramètres pour avoir la liste des 25 biens 
            $resultat = DB::select("SELECT id_mutation , date_mutation, annee_mutation, nature_mutation, valeur_fonciere,
                CONCAT(adresse_numero, adresse_suffixe, ' ', adresse_nom_voie) as adresse,
                code_postal, code_commune, nom_commune, id_parcelle,  type_local, 
                surface_reelle_bati, nombre_pieces_principales, surface_terrain, 
                z_prixm2, geom, ROUND(ST_Distance(geom, ref_geom)) AS distance, latitude, longitude  
                FROM dvfneocy CROSS JOIN (SELECT ST_MakePoint(:longitude,:latitude)::geography AS ref_geom) AS r  
                WHERE 
                    code_commune = :code_commune
                    AND nature_mutation = :nature_mutation
                    AND type_local = :type_local 
                    AND nombre_pieces_principales = :nombre_pieces_principales  
                    AND ST_DWithin(geom, ref_geom, 2500)
                    AND valeur_fonciere BETWEEN :prix_min and :prix_max
                ORDER BY ST_Distance(geom, ref_geom) LIMIT 25",

                ['longitude' => $requete['longitude'],
                'latitude' => $requete['latitude'],
                'code_commune' => $code_commune,
                'nature_mutation' => $requete['nature_mutation'],
                'type_local' => $requete['type_local'],
                'nombre_pieces_principales' => $requete['nombre_pieces_principales'],
                'prix_min' => $requete['prix_min'],
                'prix_max' => $requete['prix_max'] ]
            );
            }

            //vérifie si la requête n'est pas vide
            if($resultat == []) {
                $erreur = "Il se pourrait qu'aucun bien n'ait été vendu aux alentours de l'adresse fournie.";
                return view('rechercheBienGeocoder', ['erreur' => $erreur]);
            }

            //on recupere les parametrès du second formulaire de session pour enregistrer la requete de 
            //l'utilisateur dans la BDD
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
            
            //requete avec le code commune qu'on a extrait précédemment et les paramètres venant de
            //la requete de l'utilisateur pour faire l'analyse des biens
            $analyses = DB::select("SELECT distinct(annee_mutation), code_departement, code_postal, code_commune, type_local, nature_mutation, 
            categorie, nb_transactions, avg_prix_m2, avg_surface_m2
            FROM prixneocy
            WHERE 
                code_commune = :code_commune
                AND nature_mutation = :nature_mutation
                AND type_local = :type_local
                AND categorie LIKE :categorie
            ORDER BY annee_mutation",

            ['code_commune' => $code_commune, //le code commune de la requete Commune
            'nature_mutation' => $requete['nature_mutation'],
            'type_local' => $requete['type_local'],
            'categorie' => 'T'.$requete['nombre_pieces_principales'].'%' ] //categorie = nb pièces dans la requete
            );
            
            session(['res' => $resultat]); 
            session(['req' => [
                'longitude' => $requete['longitude'], 
                'latitude' => $requete['latitude'], 
                'adresse' => $requete['adresse']
            ]]);
            return view('map', [ 'analyses' => $analyses, 'commune' => $commune]);
        } catch(\Exception $e) {
            $erreur = "Essayez de rentrer une autre adresse.";
            return view('rechercheBienGeocoder', ['erreur' => $erreur]);
        }
    }

    //quand l'utilisateur veut voir sa requete à partir de ses évaluations sauvegardées 
    public function voirRequete($req_id)
    {
        $requete = DB::table('requetes')->find($req_id); //on cherche dans la BDD sa requete

        $type_bien = $requete->type_bien; //on recupère les parametres 
        $nature_mutation = $requete->age_bien;
        $nb_pieces = $requete->nombre_pieces;
        $prix_min = $requete->prix_min;
        $prix_max = $requete->prix_max;
        
        $nom_commune = $requete->nom_commune;
        $code_postal = $requete->code_postal;
        $adresse = $requete->adresse;
        $longitude = $requete->longitude;
        $latitude = $requete->latitude;

        //requete pour trouver les infos de la commune
        $commune = DB::select("SELECT code_commune, code_postal, nom_commune, population
        FROM communes
        WHERE 
            code_postal = :code_postal",

        [ 'code_postal' => $code_postal ] //en paramètre le code postal de la requete de l'utilisateur
        );
        $code_commune = $commune[0]->code_commune; //$commune est un array, on extrait code_commune
        
        //on compte le nombre de lignes de la requete
        $count_commune = count((array)$commune);

        //si y a plus d'une ligne, ça signifie qu'un code postal appartient à plusieurs communes
        //donc on refait la requete avec cp et nom commune en paramètre
        if($count_commune > 1)
        {
            $commune_exacte = DB::select("SELECT code_commune, code_postal, nom_commune, population
            FROM communes
            WHERE 
                nom_commune LIKE :nom_commune
                AND code_postal = :code_postal",

            [ 'nom_commune' => '%'.$nom_commune.'%', 
            'code_postal' => $code_postal ] //en paramètre le code postal et le nom commune de la requete de l'utilisateur
            );

            $code_commune = $commune_exacte[0]->code_commune;
            $commune = $commune_exacte;
        }

        //lorsque l'utilisateur souhaite voir sa requete avec 5 pièces et plus
        if($nb_pieces == 5)
            {
                $resultat_plus_de_5_pieces = DB::select("SELECT id_mutation , date_mutation, annee_mutation, nature_mutation, valeur_fonciere,
                CONCAT(adresse_numero, adresse_suffixe, ' ', adresse_nom_voie) as adresse,
                code_postal, code_commune, nom_commune, id_parcelle,  type_local, 
                surface_reelle_bati, nombre_pieces_principales, surface_terrain, 
                z_prixm2, geom, ROUND(ST_Distance(geom, ref_geom)) AS distance, latitude, longitude  
                FROM dvfneocy CROSS JOIN (SELECT ST_MakePoint(:longitude,:latitude)::geography AS ref_geom) AS r  
                WHERE 
                    code_commune = :code_commune
                    AND nature_mutation = :nature_mutation
                    AND type_local = :type_local 
                    AND nombre_pieces_principales IN (5,6,7,8,9,10) /*nombre de pièces*/
                    AND ST_DWithin(geom, ref_geom, 2500)
                    AND valeur_fonciere BETWEEN :prix_min and :prix_max
                ORDER BY ST_Distance(geom, ref_geom) LIMIT 25",

                ['longitude' => $longitude,
                'latitude' => $latitude,
                'code_commune' => $code_commune,
                'nature_mutation' => $nature_mutation,
                'type_local' => $type_bien,
                'prix_min' => $prix_min,
                'prix_max' => $prix_max ]
                );
                $resultat = $resultat_plus_de_5_pieces;
            }
            else{
            //meme requete avec les paramètres pour avoir la liste de biens 
            $resultat = DB::select("SELECT id_mutation , date_mutation, annee_mutation, nature_mutation, valeur_fonciere,
                CONCAT(adresse_numero, adresse_suffixe, ' ', adresse_nom_voie) as adresse,
                code_postal, code_commune, nom_commune, id_parcelle,  type_local, 
                surface_reelle_bati, nombre_pieces_principales, surface_terrain, 
                z_prixm2, geom, ROUND(ST_Distance(geom, ref_geom)) AS distance, latitude, longitude  
                FROM dvfneocy CROSS JOIN (SELECT ST_MakePoint(:longitude,:latitude)::geography AS ref_geom) AS r  
                WHERE 
                    code_commune = :code_commune
                    AND nature_mutation = :nature_mutation
                    AND type_local = :type_local 
                    AND nombre_pieces_principales = :nombre_pieces_principales  
                    AND ST_DWithin(geom, ref_geom, 2500)
                    AND valeur_fonciere BETWEEN :prix_min and :prix_max
                ORDER BY ST_Distance(geom, ref_geom) LIMIT 25",

                ['longitude' => $longitude,
                'latitude' => $latitude,
                'code_commune' => $code_commune,
                'nature_mutation' => $nature_mutation,
                'type_local' => $type_bien,
                'nombre_pieces_principales' => $nb_pieces,
                'prix_min' => $prix_min,
                'prix_max' => $prix_max ]
            );
            }

        //requete avec le code commune qu'on a extrait précédemment et les paramètres venant de
        //la requete de l'utilisateur pour faire l'analyse des biens
        $analyses = DB::select("SELECT distinct(annee_mutation), code_departement, code_postal, code_commune, type_local, nature_mutation, 
        categorie, nb_transactions, avg_prix_m2, avg_surface_m2
        FROM prixneocy
        WHERE 
            code_commune = :code_commune
            AND nature_mutation = :nature_mutation
            AND type_local = :type_local
            AND categorie LIKE :categorie
        ORDER BY annee_mutation",

        ['code_commune' => $code_commune, //code commune de la requete $commune
        'nature_mutation' => $nature_mutation,
        'type_local' => $type_bien,
        'categorie' => 'T'.$nb_pieces.'%' ] //categorie = nb pièces dans la requete
        );
        session(['res' => $resultat]); 
        session(['req' => [
            'longitude' => $requete->longitude, 
            'latitude' => $requete->latitude, 
            'adresse' => $requete->adresse
        ]]);
        return view('map', [ 'analyses' => $analyses, 'commune' => $commune]);
    }

    public function supprimerRequete($reqid) //l'utilisateur veut supprimer une requete
    {
        $requete = Requete::find($reqid) ;
        $requete->delete();

        return redirect()->back()->with('info',"Votre requete a été supprimée");
    }
}
