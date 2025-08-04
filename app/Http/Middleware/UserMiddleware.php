<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->utype === 'USR') {
            return $next($request);
        }

        if (Auth::check() && (Auth::user()->utype === 'ADM' || Auth::user()->utype === 'SPRADM')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have access to the user dashboard.');
        }

        // If not authenticated at all
        return redirect('/login')->with('error', 'Please log in to access this page.');
    }
}
