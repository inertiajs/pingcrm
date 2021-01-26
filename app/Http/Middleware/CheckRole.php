<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // if ($role == 'user' && auth()->user()->owner) {
        //     abort(403);
        // }

        if ($role == 'owner' && !auth()->user()->owner) {
            abort(403);
        }

        return $next($request);
    }
}
