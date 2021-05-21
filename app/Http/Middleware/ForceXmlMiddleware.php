<?php

namespace App\Http\Middleware;

use Closure;

class ForceXmlMiddleware
{
    /**
     * Handle an incoming request by forcing to send only Xml
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         $request->headers->set('Accept', 'application/xml');
        return $next($request);
    }
}
