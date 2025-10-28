<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Get locale from session, fallback to default 'id'
        $locale = session('locale', 'id');
        
        // Validate locale
        $availableLocales = ['en', 'id'];
        if (!in_array($locale, $availableLocales)) {
            $locale = 'id';
        }
        
        App::setLocale($locale);
        
        return $next($request);
    }
}
