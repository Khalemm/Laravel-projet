<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requete;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Commune;
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
        
        //les variables du geocoder
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
        //on recupere les variables du geocoder et on les range dans la session de l'utilisateur
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

        $requete->merge( session('clé' ) ); //session avec les variables du geocoder
        $id_user = Auth::id(); //id de l'utilisateur

        //si l'utilisateur n'a pas mis de prix min et max dans le formulaire, on leur associe une valeur pour 
        //pouvoir faire la requete $resultat
        if ($requete['prix_min'] == null) //prix min facultatif
        {
            $requete['prix_min'] = 0;
        }

        if ($requete['prix_max'] == null) //prix max facultatif
        {
            $requete['prix_max'] = 2000000;
        }
        
        //si jamais une erreur insoupconné arrive, on fait ici un try/catch
        try{
            //requete pour trouver les infos de la commune
            //en paramètre le code postal venant du geocoder
            $commune = DB::table('communes')->where('code_postal', $requete['code_postal'])->get(); 
            $code_commune = $commune[0]->code_commune; //$commune est un array, on extrait code_commune
            
            //on compte le nombre de lignes de la requete
            $count_commune = count($commune);

            //si y a plus d'une ligne, ça signifie qu'un code postal appartient à plusieurs communes
            //donc on refait la requete avec cp et nom commune en paramètre
            if($count_commune > 1)
            {
                $commune_exacte = DB::table('communes')
                    ->where('code_postal', $requete['code_postal']) //en paramètre le code postal et le nom commune venant du geocoder
                    ->where('nom_commune', 'like', '%'.$requete['nom_commune'].'%') 
                    ->get();

                $code_commune = $commune_exacte[0]->code_commune; ////on extrait le code commune
                $commune = $commune_exacte;
            }

            //résultat de la recherche des biens
            if($requete['nombre_pieces_principales'] == 5) //si l'utilisateur a mis dans le formulaire 5 pièces et plus
            {
                $resultat_plus_de_5_pieces = DB::select("SELECT id_mutation , date_mutation, annee_mutation, nature_mutation, 
                valeur_fonciere, CONCAT(adresse_numero, adresse_suffixe, ' ', adresse_nom_voie) as adresse,
                code_postal, code_commune, nom_commune, id_parcelle,  type_local, 
                surface_reelle_bati, nombre_pieces_principales, surface_terrain, 
                z_prixm2, geom, ROUND(ST_Distance(geom, ref_geom)) AS distance, latitude, longitude  
                FROM dvfneocy CROSS JOIN (SELECT ST_MakePoint(:longitude,:latitude)::geography AS ref_geom) AS r  
                WHERE 
                    code_commune = :code_commune
                    AND nature_mutation = :nature_mutation
                    AND type_local = :type_local 
                    AND nombre_pieces_principales >= 5 /*nombre de pièces de 5 et plus*/
                    AND ST_DWithin(geom, ref_geom, 2500)
                    AND valeur_fonciere BETWEEN :prix_min and :prix_max
                ORDER BY ST_Distance(geom, ref_geom) LIMIT 25",

                ['longitude' => $requete['longitude'], //en paramètre les variables du geocoder
                'latitude' => $requete['latitude'],
                'code_commune' => $code_commune, //code commune de la requete $commune
                'nature_mutation' => $requete['nature_mutation'], //en paramètre ce que l'utilisateur a saisi dans le formulaire
                'type_local' => $requete['type_local'],
                'prix_min' => $requete['prix_min'],
                'prix_max' => $requete['prix_max'] ]
                );
                $resultat = $resultat_plus_de_5_pieces;
            }
            else{
                //meme requete pour afficher le résultat de la recherche des biens
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

                ['longitude' => $requete['longitude'], //en paramètre les variables du geocoder
                'latitude' => $requete['latitude'],
                'code_commune' => $code_commune, //code commune de la requete $commune
                'nature_mutation' => $requete['nature_mutation'], //en paramètre ce que l'utilisateur a saisi dans le formulaire
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

            //on recupere les variables du geocoder et les valeurs saisies du second formulaire de session pour enregistrer 
            //la requete de l'utilisateur dans la base de données
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

            //requete avec le code commune qu'on a extrait précédemment et les valeurs saisies du formulaire
            //pour faire l'analyse des biens par an
            $analyses = DB::table('prixneocy')
            ->distinct()
            ->where('code_commune', $code_commune) //code commune de la requete $commune
            ->where('nature_mutation', $requete['nature_mutation'])
            ->where('type_local', $requete['type_local'])
            ->where('categorie', 'like', 'T'.$requete['nombre_pieces_principales'].'%') //categorie = nb pièces
            ->orderBy('annee_mutation')
            ->get();
            
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
        $requete = DB::table('requetes')->find($req_id); //on cherche dans la base de données la requete de l'utilisateur connecté

        $type_bien = $requete->type_bien; //on recupère chaque info pour les utiliser dans les requetes qui suivent en paramètre
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
        //en paramètre le code postal de la requete de l'utilisateur
        $commune = DB::table('communes')->where('code_postal', $code_postal)->get();
        $code_commune = $commune[0]->code_commune; //$commune est un array, on extrait code_commune
        
        //on compte le nombre de lignes de la requete
        $count_commune = count($commune);

        //si y a plus d'une ligne, ça signifie qu'un code postal appartient à plusieurs communes
        //donc on refait la requete avec cp et nom commune en paramètre
        if($count_commune > 1)
        {
            $commune_exacte = DB::table('communes')
                ->where('code_postal', $code_postal) //en paramètre le code postal et le nom commune de la requete de l'utilisateur
                ->where('nom_commune', 'like', '%'.$nom_commune.'%') 
                ->get();

            $code_commune = $commune_exacte[0]->code_commune;
            $commune = $commune_exacte;
        }

        //résultat de la recherche des biens
        if($nb_pieces == 5) //si l'utilisateur a mis dans le formulaire 5 pièces et plus
            {
                $resultat_plus_de_5_pieces = DB::select("SELECT id_mutation , date_mutation, annee_mutation, nature_mutation,
                valeur_fonciere, CONCAT(adresse_numero, adresse_suffixe, ' ', adresse_nom_voie) as adresse,
                code_postal, code_commune, nom_commune, id_parcelle,  type_local, 
                surface_reelle_bati, nombre_pieces_principales, surface_terrain, 
                z_prixm2, geom, ROUND(ST_Distance(geom, ref_geom)) AS distance, latitude, longitude  
                FROM dvfneocy CROSS JOIN (SELECT ST_MakePoint(:longitude,:latitude)::geography AS ref_geom) AS r  
                WHERE 
                    code_commune = :code_commune
                    AND nature_mutation = :nature_mutation
                    AND type_local = :type_local 
                    AND nombre_pieces_principales >= 5 /*nombre de pièces de 5 et plus*/
                    AND ST_DWithin(geom, ref_geom, 2500)
                    AND valeur_fonciere BETWEEN :prix_min and :prix_max
                ORDER BY ST_Distance(geom, ref_geom) LIMIT 25",

                ['longitude' => $longitude, //en paramètre les infos venant de $requete
                'latitude' => $latitude,
                'code_commune' => $code_commune, //code commune de la requete $commune
                'nature_mutation' => $nature_mutation,
                'type_local' => $type_bien,
                'prix_min' => $prix_min,
                'prix_max' => $prix_max ]
                );
                $resultat = $resultat_plus_de_5_pieces;
            }
            else{
            //meme requete pour le résultat de la recherche des biens
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

                ['longitude' => $longitude, //en paramètre les infos venant de $requete
                'latitude' => $latitude,
                'code_commune' => $code_commune, //code commune de la requete $commune
                'nature_mutation' => $nature_mutation,
                'type_local' => $type_bien,
                'nombre_pieces_principales' => $nb_pieces,
                'prix_min' => $prix_min,
                'prix_max' => $prix_max ]
            );
            }

        //requete avec le code commune qu'on a extrait précédemment et les infos venant de la $requete
        //pour faire l'analyse des biens par an
        $analyses = DB::table('prixneocy')
        ->distinct()
        ->where('code_commune', $code_commune) //code commune de la requete $commune
        ->where('nature_mutation', $nature_mutation)
        ->where('type_local', $type_bien)
        ->where('categorie', 'like', 'T'.$nb_pieces.'%') //categorie = nb pièces
        ->orderBy('annee_mutation')
        ->get();

        session(['res' => $resultat]); 
        session(['req' => [
            'longitude' => $requete->longitude, 
            'latitude' => $requete->latitude, 
            'adresse' => $requete->adresse
        ]]);
        return view('map', [ 'analyses' => $analyses, 'commune' => $commune]);
    }

    public function supprimerRequete($reqid) //quand l'utilisateur veut supprimer une requete
    {
        $requete = Requete::find($reqid) ;
        $requete->delete();

        return redirect()->back()->with('info',"Votre évaluation a été supprimée");
    }
}
