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
        if(getSite()->active == 0)
        {
            if (getAuthUser() && !empty(getAuthUser()->getRole()) && in_array(getAuthUser()->getRole()->id, [1, 2])){

                return $next($request);
            }
            return redirect()->route('offline');
        }   
        return $next($request);
        

    }
}
