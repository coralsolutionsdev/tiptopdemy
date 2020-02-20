<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;
use App\site;

class IsActive
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
        $site = Site::all()->last();
        
        if($site->active == 0)
        {
            //return redirect()->route('offline');
            if (Auth::check() and Auth::user()->role == 'admin') {
                return $next($request);
            }
            return redirect()->route('offline');
        }   
        return $next($request);
        

    }
}
