<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Allow if session indicates admin or authenticated user has is_admin
        if (session('is_admin') === true) {
            return $next($request);
        }

        if (Auth::check() && data_get(Auth::user(), 'is_admin')) {
            return $next($request);
        }

    // redirect to panel login
    return redirect()->route('panel.login');
    }
}
