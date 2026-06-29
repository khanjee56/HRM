<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HrMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check() && in_array(auth()->user()->role, ['superadmin', 'hr'])) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized access!');
    }
}