<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class AdminLoginCheck
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
        if( !Session::has('loggedin') )
            return redirect('/admin/login');

        return $next($request);
    }
}
