<?php

namespace App\Http\Middleware;

use Closure;

class installMiddleware
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

        $ins = env('DB_HOST', false);

        if( $ins!=false )
            return $next($request);

        else
        {
            return redirect()->to( '/instalar' );
        }
    }
}
