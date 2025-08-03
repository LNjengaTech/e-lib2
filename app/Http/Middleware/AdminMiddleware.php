<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and if their utype is 'ADM' OR 'SPRADM'
        if (Auth::check() && (Auth::user()->utype === 'ADM' || Auth::user()->utype === 'SPRADM')) {
            return $next($request); // User is an admin or super admin, proceed
        }

        // If not an admin or super admin, redirect them or abort with a 403 Forbidden error.
        return redirect('/dashboard')->with('error', 'You do not have administrative access.');
        // Alternatively, to show a 403 page:
        // abort(403, 'Unauthorized access.');
    }
}
