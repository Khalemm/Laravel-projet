<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Abonnement;

class AbonnementController extends Controller
{
    public function showAbonnement()
    {
        $abonnements = Abonnement::all(); //montre tous les abonnements
        return view('abonnements', compact('abonnements'));
    }
}
