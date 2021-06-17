<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); //cherche tous les users
        return view('users', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id); //cherche user par l'id
        //$user = User::where('name', '=', 'nana')->get(); //->first() pour avoir la 1ère valeur du tableau //on peut enlever le =
        //$user = User::orderBy('name')->take(2)->get(); //affiche 2 users

        return view('user_requete', [ 'user' => $user]);
    }

    /*public function formulaire_update() {
        return view('user_update');
    }*/

    public function update($id, Request $requete) //mettre à jour le profil de l'utilisateur
    {
        $user = User::findOrFail($id);
        $user->update([
            //name
            'last_name' => $requete->input(['last_name']),
            'tel_fixe' => $requete->input(['tel_fixe']),
            'tel_mobile' => $requete->input(['tel_mobile']),
            'nom_entreprise' => $requete->input(['nom_entreprise']),
            'adresse_entreprise' => $requete->input(['adresse_entreprise']),
            'code_postal' => $requete->input(['code_postal']),
            'ville_entreprise' => $requete->input(['ville_entreprise'])
        ]);

        return view('user_profil', [ 'user' => $user]);
    }
}
