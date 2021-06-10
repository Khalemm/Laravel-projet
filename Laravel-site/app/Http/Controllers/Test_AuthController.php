<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class Test_AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('dodo'); //faut se connecter pour avoir accès à dada, pas nécessaire pour dodo
    }

    public function dada()
    {
        if(!Gate::allows('access-admin')) //si on est pas admin, on a pas accès à dada
        {
            abort('403');
        }
        return view('test.dada');
    }

    public function dodo()
    {
        return view('test.dodo');
    }
}
