<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

        return view('show_user', [ 'user' => $user]);
    }
}
