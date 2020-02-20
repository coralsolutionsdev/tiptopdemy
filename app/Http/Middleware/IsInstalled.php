<?php

namespace App\Http\Middleware;

use Closure;
use App\Site;

class IsInstalled
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


        $count = Site::all()->count();
        if($count ==0){

        return redirect()->route('site.create');
        }else{
            return $next($request);
        }

    }
}
