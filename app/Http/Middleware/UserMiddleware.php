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
       // Check if the user is authenticated and if their utype is 'USR'
        if (Auth::check() && Auth::user()->utype === 'USR') {
            return $next($request); // User is a regular user, proceed
        }

        // If not a regular user (i.e., ADM or SPRADM), redirect them.
        // Admins and Super Admins should be redirected to their respective dashboards.
        if (Auth::check() && (Auth::user()->utype === 'ADM' || Auth::user()->utype === 'SPRADM')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have access to the user dashboard.');
        }

        // If not authenticated at all, redirect to login (or wherever your 'auth' middleware sends them)
        return redirect('/login')->with('error', 'Please log in to access this page.');
    }
}
