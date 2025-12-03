<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageUrl
{
    /**
     * Resolve an image path from DB to a usable URL with fallbacks.
     * 
     * PRODUCTION-READY: Multiple fallback strategies
     * 1. Check exact path on public disk
     * 2. Try common folder variations
     * 3. Check physical file existence via symlink
     * 4. Fallback to placeholder
     */
    public static function url(?string $path): string
    {
        if (empty($path)) {
            return asset('favicon.ico');
        }

        // Clean path (remove leading slashes)
        $path = ltrim($path, '/');

        // Strategy 1: Check exact path on public disk (MOST COMMON)
        try {
            if (Storage::disk('public')->exists($path)) {
                // Build URL manually for better reliability
                $url = config('app.url') . '/storage/' . $path;
                return $url;
            }
        } catch (\Exception $e) {
            // Continue to fallbacks
        }

        $basename = basename($path);

        // Strategy 2: Try common folder variations
        $candidates = [
            $path,
            'uploads/' . $basename,
            'uploads/destinasi/' . $basename,
            'uploads/akomodasi/' . $basename,
            'uploads/transportasi/' . $basename,
            'uploads/services/' . $basename,
            'uploads/events/' . $basename,
        ];

        foreach ($candidates as $candidate) {
            try {
                if (Storage::disk('public')->exists($candidate)) {
                    $url = config('app.url') . '/storage/' . $candidate;
                    return $url;
                }
            } catch (\Exception $e) {
                // Continue
            }
        }

        // Strategy 3: Check physical symlink path (for production where Storage facade might fail)
        $symlinkPath = public_path('storage/' . $path);
        if (file_exists($symlinkPath) && is_file($symlinkPath)) {
            return asset('storage/' . $path);
        }

        // Try symlink with candidates
        foreach ($candidates as $candidate) {
            $symlinkPath = public_path('storage/' . $candidate);
            if (file_exists($symlinkPath) && is_file($symlinkPath)) {
                return asset('storage/' . $candidate);
            }
        }

        // Strategy 4: Check if file exists directly in public (legacy)
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // Final fallback: placeholder image
        return asset('favicon.ico');
    }
}
