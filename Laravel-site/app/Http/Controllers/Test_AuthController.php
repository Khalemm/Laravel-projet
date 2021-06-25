<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Mail\testMail;
use App\Mail\markdownMail;
use Illuminate\Support\Facades\Mail;
use App\Notifications\UserRegisteredNotification;

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
        $user =  auth()->user();
        //$mail = $user->email;

        //Mail::to($mail)->send(new testMail($user));
        //Mail::to($mail)->send(new markdownMail($user));

        $user->notify(new UserRegisteredNotification());

        //return redirect('/');
        return view('registered');
    }
}
