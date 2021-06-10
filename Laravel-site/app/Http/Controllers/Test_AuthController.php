<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Test_AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('dodo');
    }

    public function dada()
    {
        return view('test.dada');
    }

    public function dodo()
    {
        return view('test.dodo');
    }
}
