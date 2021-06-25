<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsActivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->active == 1) //si compte activé on a accès à tout, sinon forbidden
        {
            return $next($request);
        } else{
            abort('403');
            //return route('registered');
        }
    }
}
