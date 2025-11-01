<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FotoDestinasi;
use App\Models\Akomodasi;
use App\Models\Transportasi;
use Illuminate\Support\Facades\Storage;

class ReconcileImages extends Command
{
    protected $signature = 'images:reconcile {--dry : Do not write changes}';
    protected $description = 'Try to reconcile DB image paths with files in storage/app/public and update DB records';

    public function handle()
    {
        $dry = $this->option('dry');

        $this->info('Scanning storage files...');
        $files = Storage::disk('public')->allFiles();
        $allowedExt = ['jpg','jpeg','png','webp','gif','svg','bmp','avif'];
        $map = [];
        foreach ($files as $f) {
            $base = basename($f);
            $ext = strtolower(pathinfo($base, PATHINFO_EXTENSION));
            if (str_starts_with($base, '.')) continue; // skip dotfiles
            if (!in_array($ext, $allowedExt)) continue; // only images
            $map[$base][] = $f;
        }

        $this->info('Reconciling FotoDestinasi...');
        FotoDestinasi::orderBy('id')->chunkById(200, function ($rows) use ($map, $dry) {
            foreach ($rows as $r) {
                $url = $r->url;
                if (!$url) continue;
                if (Storage::disk('public')->exists($url)) continue;

                $basename = basename($url);
                $stem = pathinfo($basename, PATHINFO_FILENAME);
                $stemStripped = preg_replace('/[-_]?\d+$/', '', $stem);

                // exact basename match
                if (!empty($map[$basename])) {
                    $new = $map[$basename][0];
                    $this->line("FotoDestinasi #{$r->id}: updating '{$url}' -> '{$new}'");
                    if (!$dry) { $r->update(['url' => $new]); }
                    continue;
                }

                // fuzzy match: find any file whose basename contains stem or vice versa
                $found = null;
                foreach ($map as $b => $candidates) {
                    $bStem = pathinfo($b, PATHINFO_FILENAME);
                    $bStemStripped = preg_replace('/[-_]?\d+$/', '', $bStem);
                    if (stripos($bStem, $stem) !== false || stripos($stem, $bStem) !== false || $bStemStripped === $stemStripped) {
                        $found = $candidates[0];
                        break;
                    }
                }

                if ($found) {
                    $this->line("FotoDestinasi #{$r->id}: fuzzy updating '{$url}' -> '{$found}'");
                    if (!$dry) { $r->update(['url' => $found]); }
                } else {
                    $this->line("FotoDestinasi #{$r->id}: no match for '{$url}'");
                }
            }
        });

        $this->info('Reconciling Akomodasi thumbnails...');
        Akomodasi::orderBy('id')->chunkById(200, function ($rows) use ($map, $dry) {
            foreach ($rows as $r) {
                if (!empty($r->thumbnail) && Storage::disk('public')->exists($r->thumbnail)) continue;

                // attempt to find by slug, nama, or id
                $candidates = [];
                $names = [];
                if (!empty($r->slug)) $names[] = $r->slug;
                if (!empty($r->nama)) $names[] = preg_replace('/\s+/', '-', strtolower($r->nama));
                $names[] = 'akomodasi-' . $r->id;

                $found = null;
                foreach ($names as $n) {
                    foreach ($map as $b => $c) {
                        if (stripos($b, $n) !== false) { $found = $c[0]; break 2; }
                    }
                }

                if ($found) {
                    $this->line("Akomodasi #{$r->id}: setting thumbnail -> {$found}");
                    if (!$dry) { $r->update(['thumbnail' => $found]); }
                }
            }
        });

        $this->info('Reconciling Transportasi thumbnails...');
        Transportasi::orderBy('id')->chunkById(200, function ($rows) use ($map, $dry) {
            foreach ($rows as $r) {
                if (!empty($r->thumbnail) && Storage::disk('public')->exists($r->thumbnail)) continue;
                $names = [];
                if (!empty($r->slug)) $names[] = $r->slug;
                if (!empty($r->nama)) $names[] = preg_replace('/\s+/', '-', strtolower($r->nama));
                $names[] = 'transportasi-' . $r->id;

                $found = null;
                foreach ($names as $n) {
                    foreach ($map as $b => $c) {
                        if (stripos($b, $n) !== false) { $found = $c[0]; break 2; }
                    }
                }

                if ($found) {
                    $this->line("Transportasi #{$r->id}: setting thumbnail -> {$found}");
                    if (!$dry) { $r->update(['thumbnail' => $found]); }
                }
            }
        });

        $this->info('Done.');
        return 0;
    }
}
