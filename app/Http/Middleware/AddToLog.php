<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\RouteLog;

class AddToLog
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
        //return $next($request);
        $response = $next($request);

        if(auth()->user() && (request()->method()=='POST' || request()->method()=='PUT' || request()->method()=='DELETE')) {
            RouteLog::create([
                'user_id' => authInfo()->id,
                'url' => request()->fullUrl(),
                'ip_address' => request()->ip()
            ]);
        }

        return $response;
    }
}
