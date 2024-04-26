<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEnvironment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (env('APP_ENV') === 'staging' | env('APP_ENV') === 'local') {
            return $next($request);
        }

        return response()->json(['error' => 'wrong app_env', 'app_env' => env('APP_ENV')], 403); // @fixme-v delete app_env after test
    }
}
