<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\user;

class AuthUser
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
            if(Auth::user()->role == 'user'){
                 return $next($request);
            }
        }

        return redirect('/login');
    }
}
