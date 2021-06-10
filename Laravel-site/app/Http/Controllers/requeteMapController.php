<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class requeteMapController extends Controller {
    // Controller pour la recherche d'une maison

    public function geocoder() {
        return view('rechercheBienGeocoder');
    }

    public function postGeocoder(Request $requete) {
        session(['clé' => $requete->only(['longitude', 'latitude', 'adresse', 'cp', 'commune'])]);
        return view('rechercheBienDetail');
    }

    public function informationsComplementaires() {
        return view('rechercheBienDetail');
    }

    public function postInformationsComplementaires(Request $requete) {
        $requete->merge(session('clé'));
        dd($requete);
        return view('rechercheBienDetail');
    }

    /**
     * Créées la requete du bien immobillier
     *
     * @param  array  $data
     * @return User
     */
    protected function creationRequete(array $data)
    {
        return $donnees = ([
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
            'adresse' => $data['adresse'],
            'age-bien' =>$data['age-bien'],
            'type' => $data['type'],
            'nb-pieces' => $data['nb-pieces'],
            'cp' => $data['cp'],
            'commune' => $data['commune'],
        ]);
    }
}
