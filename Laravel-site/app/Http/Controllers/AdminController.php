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

        $users = User::all()->sortByDesc('created_at'); //cherche tous les users
        return view("adminGestionUser", compact('users'));
    }
    
    public function activerUser($id)
    {
        $user = User::find($id);
        $user->active = 1; //activation du compte
        $user->save();

        return redirect()->back()->withSuccess("Le compte de l'utilisateur est activé");
    }

    public function desactiverUser($id)
    {
        $user = User::find($id);
        $user->active = 0; //desactive le compte
        $user->save();

        return redirect()->back()->with('info',"Le compte de l'utilisateur est desactivé");
    }

    public function supprimerUser($id)
    {
        $user = User::find($id) ;
        $user->delete();

        return redirect()->back()->with('info',"L'utilisateur a été supprimée"); //fenetre pop up ?
    }

    public function updateAdminUser($id)
    {
        $user = User::find($id);
        $user->active = 1;
        $user->admin = 1; //rend un utilisateur administrateur et active son compte
        $user->save();

        return redirect()->back()->withSuccess("L'utilisateur possède maintenant le role d'administrateur");
    }

    public function supprimerUsersNonConfirmes()
    {
        $users = User::where('email_verified_at', null)->delete(); //cherche et supprime les users sans mail verifié

        return redirect()->back()->with('info',"Les utilisateurs ont bien été supprimés");
    }

    public function updateAbonnementUser($id, Request $requete)
    {
        $user = User::find($id);
        $user->abonnement = 1;
        $user->date_abonnement = date('Y-m-d H:i:s');
        $user->date_fin_abonnement = $requete->input(['date_fin_abonnement']); 
        $user->save();
        
        return redirect()->back()->withSuccess("L'utilisateur possède un abonnement");
    }

    public function supprimerAbonnementUser($id)
    {
        $user = User::find($id);
        $user->abonnement = 0;
        $user->date_abonnement = null;
        $user->date_fin_abonnement = null;
        $user->save();

        return redirect()->back()->with('info',"L'abonnement de l'utilisateur a été supprimé");
    }
}
