<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); //faut se connecter pour avoir accès
    }

    public function index()
    {
        $users = User::all(); //cherche tous les users
        return view('users', compact('users'));
    }

    public function show()
    {
        $user =  auth()->user(); //cherche user par l'id

        return view('user_requete', [ 'user' => $user]);
    }

    public function form_update() {
        $user =  auth()->user();
        $abonnement = DB::table('abonnements')->find($user->abonnement); //on cherche dans la BDD
        //dd($abonnement->nom);
        return view('user_profil', [ 'user' => $user, 'abonnement' => $abonnement]);
    }

    public function updateProfil(Request $requete) //mettre à jour le profil de l'utilisateur
    {
        $user =  auth()->user();
        $user->update([
            'name' => $requete->input(['name']),
            'last_name' => $requete->input(['last_name']),
            'tel_fixe' => $requete->input(['tel_fixe']),
            'tel_mobile' => $requete->input(['tel_mobile'])
        ]);
        
        /*$validatedData = $request->validate([
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
            'publish_at' => 'nullable|date',
        ]);

        Validator::make($data, [
            'email' => [
                'required',
                Rule::exists('staff')->where(function ($query) {
                    return $query->where('account_id', 1);
                }),
            'user_id' => 'exists:App\Models\User,id',
            'mail' => Rule::unique('users')->where(function ($query) {
                return $query->where('account_id', 1);
            })
            ],
        ]);*/

        return redirect()->back()->withSuccess('Votre profil a été mis à jour');
    }

    public function updateEntreprise(Request $requete) //mettre à jour les infos de son entreprise
    {
        $user =  auth()->user();
        $user->update([
            'nom_entreprise' => $requete->input(['nom_entreprise']),
            'adresse_entreprise' => $requete->input(['adresse_entreprise']),
            'code_postal' => $requete->input(['code_postal']),
            'ville_entreprise' => $requete->input(['ville_entreprise'])
        ]);

        return redirect()->back()->withSuccess('Votre entreprise a été mise à jour');
    }

    public function updateAbonnement(Request $requete) //mettre à jour son abonnement
    {
        $user =  auth()->user();
        $user->update([
            'abonnement' => $requete->input(['abonnement']),
        ]);

        return redirect()->back();
    }
}
