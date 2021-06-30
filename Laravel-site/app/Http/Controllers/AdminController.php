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
    }

    public function administration() {

        if(!Gate::allows('access-admin')) //si on est pas admin, on a pas accès à la page
        {
            abort('403');
        }
        $users = User::all()->sortByDesc('created_at'); //cherche tous les users
        //DB::table('users')->orderBy('id')
        return view("adminGestionUser", compact('users'));
    }
    
    public function activerUser($id)
    {
        if(!Gate::allows('access-admin')) //si on est pas admin, on a pas accès à la page
        {
            abort('403');
        }
        $user = User::find($id);
        $user->active = 1; //activation du compte
        $user->save();

        return redirect()->back()->withSuccess('Le compte de l`utilisateur est activé');
    }

    public function desactiverUser($id)
    {
        if(!Gate::allows('access-admin')) //si on est pas admin, on a pas accès à la page
        {
            abort('403');
        }
        $user = User::find($id);
        $user->active = 0; //desactive le compte
        $user->save();

        return redirect()->back()->with('info',"Le compte de l`utilisateur est desactivé");
    }

    public function supprimerUser($id)
    {
        if(!Gate::allows('access-admin')) //si on est pas admin, on a pas accès à la page
        {
            abort('403');
        }
        $user = User::find($id) ;
        $user->delete();

        return redirect()->back()->with('info',"L'utilisateur a été supprimée"); //fenetre pop up ?
    }

    public function updateAdminUser($id)
    {
        if(!Gate::allows('access-admin')) //si on est pas admin, on a pas accès à la page
        {
            abort('403');
        }
        $user = User::find($id);
        $user->active = 1;
        $user->admin = 1; //rend un utilisateur administrateur et active son compte
        $user->save();

        return redirect()->back()->withSuccess('L`utilisateur possède maintenant le role d`administrateur');
    }

    public function supprimerUsersNonConfirmes()
    {
        if(!Gate::allows('access-admin')) //si on est pas admin, on a pas accès à la page
        {
            abort('403');
        }
        $users = User::where('email_verified_at', null)->delete(); //cherche et supprime les users sans mail verifié

        return redirect()->back()->with('info',"Les utilisateurs ont bien été supprimés");
    }
}
