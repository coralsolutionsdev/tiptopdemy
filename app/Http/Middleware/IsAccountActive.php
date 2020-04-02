<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Auth;

class IsAccountActive
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
            if (Auth::user()->getRole()->name == 'superadministrator' || Auth::user()->getRole()->name == 'administrator' || Auth::user()->status == User::STATUS_ACTIVE){
                return $next($request);
            }
            return redirect()->route('suspended');
        }else{
            return redirect()->route('main');
        }
        return $next($request);
    }
}
