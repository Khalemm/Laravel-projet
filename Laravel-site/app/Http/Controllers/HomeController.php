<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\UserRegisteredNotification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function registered()
    {
        $user =  auth()->user();
        $user->notify(new UserRegisteredNotification()); //envoie un mail indiquant que son compte a bien été créé

        //return view('registered');
        return redirect()->route('accueil');
    }
}
