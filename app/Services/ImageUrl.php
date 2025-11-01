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
     */
    public static function url(?string $path): string
    {
        if (empty($path)) {
            return asset('favicon.ico');
        }

        // If exact path exists on public disk
        try {
            if (Storage::disk('public')->exists($path)) {
                return Storage::url($path);
            }
        } catch (\Exception $e) {
            // ignore and try other fallbacks
        }

    $basename = basename($path);
    $stem = pathinfo($basename, PATHINFO_FILENAME);
    // strip trailing numeric suffixes like '-1', '_1'
    $stem = preg_replace('/[-_]?\d+$/', '', $stem);

        // Try common folders
        $candidates = [
            $path,
            'uploads/' . $basename,
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
            // check public path as last resort
            if (file_exists(public_path($c))) {
                return asset($c);
            }
        }

        // try scanning storage public for a file that fuzzily matches the stem
        try {
            $files = Storage::disk('public')->allFiles();
            foreach ($files as $f) {
                $fileBase = basename($f);
                $fileStem = pathinfo($fileBase, PATHINFO_FILENAME);
                // strip trailing numbers
                $fileStemStripped = preg_replace('/[-_]?\d+$/', '', $fileStem);
                if ($fileBase === $basename || $fileStem === $stem || stripos($fileStem, $stem) !== false || stripos($stem, $fileStem) !== false || $fileStemStripped === $stem) {
                    return Storage::url($f);
                }
            }
        } catch (\Exception $e) {
            // ignore
        }

        return asset('favicon.ico');
    }
}
