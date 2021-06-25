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

    public function index()
    {
        if(!Gate::allows('access-admin')) //si on est pas admin, on a pas accès à la page
        {
            abort('403');
        }

        $users = User::all(); //cherche tous les users
        return view('users', compact('users'));
    }

    public function activerUser($id)
    {
        if(!Gate::allows('access-admin')) //si on est pas admin, on a pas accès à la page
        {
            abort('403');
        }
        $user = User::find($id);
        $user->update([
            'active' => $requete->input(['active'])
        ]);
        return redirect()->back()->withSuccess('Le compte de l`utilisateur est activé');
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
        $user->update([
            'admin' => $requete->input(['active'])
        ]);
        return redirect()->back()->withSuccess('L`utilisateur possède maintenant le role d`administrateur');
    }

    public function voirUser($id)
    {
        if(!Gate::allows('access-admin')) //si on est pas admin, on a pas accès à la page
        {
            abort('403');
        }
        $user = User::find($id);
        return view('user', [ 'user' => $user]);
    }
}
