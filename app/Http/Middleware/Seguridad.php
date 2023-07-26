<?php

namespace Jugueteria\Http\Middleware;
// use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exception\JWTException;
use JWTAuth;
use Session;

use Closure;

class Seguridad
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {

        // if(auth()->check() && auth()->user()->TipoUsuario == 1){
        // if (Auth::check() && Auth::user()->TipoUsuario = 1) {
        //     return redirect('/Usuarios');
        // }
        // else{
        //     return redirect('/');
        // }

        // return $next($request);

        // $Auten = auth()->check();
        // return $Auten;


        // if(auth()->check() && auth()->user()->TipoUsuario == 1)
        //     return $next($request);

        // return redirect('/Usuarios');

        JWTAuth::parseToken()->authenticate();
            return $next($request);
    }
}
