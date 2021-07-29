<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //faut se connecter pour avoir accès
        $this->middleware('admin'); //accès seulement aux admin
    }

    public function administration() {

        $users = User::all()->sortByDesc('created_at'); //cherche tous les utilisateurs
        return view("adminGestionUser", compact('users'));
    }
    
    public function activerUser($id) //activation du compte de l'utilisateur
    {
        $user = User::find($id);
        $user->active = 1; 
        $user->save(); //update dans la base de données

        return redirect()->back()->withSuccess("Le compte de l'utilisateur est activé");
    }

    public function desactiverUser($id) //desactivation du compte de l'utilisateur
    {
        $user = User::find($id);
        $user->active = 0; //desactive le compte
        $user->save();

        return redirect()->back()->with('info',"Le compte de l'utilisateur a été desactivé");
    }

    public function supprimerUser($id) //supprime le compte de l'utilisateur
    {
        $user = User::find($id) ;
        $user->delete(); //supprime dans la base de données

        return redirect()->back()->with('info',"L'utilisateur a été supprimée");
    }

    public function updateAdminUser($id) //rend un utilisateur administrateur
    {
        $user = User::find($id);
        $user->admin = 1;
        $user->save(); //update dans la base de données

        return redirect()->back()->withSuccess("L'utilisateur possède maintenant le role d'administrateur");
    }

    public function deleteAdminUser($id) //enlève le role administrateur à un utilisateur
    {
        $user = User::find($id);
        $user->admin = 0;
        $user->save(); //update dans la base de données

        return redirect()->back()->with('info',"L'utilisateur n'a plus le role d'administrateur");
    }

    public function supprimerUsersNonConfirmes()
    {
        $users = User::where('email_verified_at', null)->delete(); //cherche et supprime les users sans mail verifié

        return redirect()->back()->with('info',"Les utilisateurs ont bien été supprimés");
    }

    public function updateAbonnementUser($id, Request $requete) //ajoute ou modifie l'abonnement d'un utilisateur
    {
        $user = User::find($id);
        $user->abonnement = 1;
        $user->date_abonnement = $requete->input(['date_abonnement']); //date début saisie dans le champ
        $user->date_fin_abonnement = $requete->input(['date_fin_abonnement']); //date de fin saisie dans le champ
        $user->save(); //update dans la base de données
        
        return redirect()->back()->withSuccess("L'abonnement de l'utilisateur a été mis à jour");
    }

    public function supprimerAbonnementUser($id) //supprime l'abonnement de l'utilisateur
    {
        $user = User::find($id);
        $user->abonnement = 0;
        $user->date_abonnement = null; 
        $user->date_fin_abonnement = null; //les 2 dates sont nul
        $user->save(); //update dans la base de données

        return redirect()->back()->with('info',"L'abonnement de l'utilisateur a été supprimé");
    }
}
