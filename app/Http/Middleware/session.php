<?php

namespace App\Http\Middleware;

use Closure;

class session
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
        
        if(session('status') != 1){
        return redirect('error');
        }
       
        
      //  return $next($request);
        
    }
}
