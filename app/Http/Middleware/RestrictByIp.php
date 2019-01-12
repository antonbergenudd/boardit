<?php

namespace boardit\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RestrictByIp
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
        $accepted_ips = [
            '127.0.0.1', // Lokal
        ];

        if(count($accepted_ips) >= 1 )
        {
            if(! in_array($request->ip(), $accepted_ips))
            {
                Log::warning("Unauthorized IP reach:".$request->ip());
                abort(404);
            }
        }

        return $next($request);
    }
}
