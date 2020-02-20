<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;

class AuthAdmin
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
        if(Auth::check()){
            if(Auth::user()->role == 'admin'){
                 return $next($request);
            }
         
        }
        return redirect('/login');
    }
}
