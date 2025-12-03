<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageUrl
{
    /**
     * Resolve an image path from DB to a usable URL with fallbacks.
     * - if path exists on public disk -> Storage::url(path)
     * - try common subfolders for basename
     * - if file exists under public/ -> asset(path)
     * - fall back to favicon
     * 
     * OPTIMIZED: Removed expensive allFiles() scan for better performance
     */
    public static function url(?string $path): string
    {
        if (empty($path)) {
            return asset('favicon.ico');
        }

        // If exact path exists on public disk - MOST COMMON CASE
        try {
            if (Storage::disk('public')->exists($path)) {
                return Storage::url($path);
            }
        } catch (\Exception $e) {
            // ignore and try other fallbacks
        }

        $basename = basename($path);

        // Try common folders - check most likely locations first
        $candidates = [
            $path,
            'uploads/' . $basename,
            'uploads/destinasi/' . $basename,
            'uploads/akomodasi/' . $basename,
            'uploads/transportasi/' . $basename,
            'uploads/services/' . $basename,
            'uploads/events/' . $basename,
            'destinasi/' . $basename,
            'akomodasi/' . $basename,
            'transportasi/' . $basename,
        ];

        foreach ($candidates as $c) {
            try {
                if (Storage::disk('public')->exists($c)) {
                    return Storage::url($c);
                }
            } catch (\Exception $e) {
                // ignore
            }
        }

        // Check public path as last resort (for legacy files)
        foreach ($candidates as $c) {
            if (file_exists(public_path($c))) {
                return asset($c);
            }
        }

        // Fallback to placeholder
        return asset('favicon.ico');
    }
}
