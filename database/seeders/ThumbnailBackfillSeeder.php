<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Akomodasi;
use App\Models\Transportasi;

class ThumbnailBackfillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder will attempt to find a suitable image file in the public disk
     * for records that have an empty thumbnail and set the thumbnail to a
     * best-effort path. It is safe to run multiple times.
     *
     * To perform a dry-run without writing, set environment variable DRY_RUN=1
     * e.g. in fish:
     *   env DRY_RUN=1 php artisan db:seed --class=ThumbnailBackfillSeeder
     */
    public function run()
    {
        $dry = env('DRY_RUN', false);

        $this->info('Starting ThumbnailBackfillSeeder (dry-run=' . ($dry ? 'yes' : 'no') . ')');

        $this->processModel(Akomodasi::class, 'akomodasi');
        $this->processModel(Transportasi::class, 'transportasi');

        $this->info('Done');
    }

    protected function processModel(string $modelClass, string $folderHint)
    {
        $records = $modelClass::whereNull('thumbnail')->orWhere('thumbnail', '')->get();
        $this->info("Processing {$records->count()} records for {$modelClass}");

        $files = collect(Storage::disk('public')->allFiles())->filter(function ($f) {
            return preg_match('/\.(jpe?g|png|webp)$/i', $f);
        })->values();

        foreach ($records as $rec) {
            $name = preg_replace('/[^a-z0-9\-]/i', '-', strtolower($rec->nama ?? ($rec->title ?? '')));
            $candidates = [];

            // prefer dedicated folder
            $candidates[] = $folderHint . '/' . $name . '.jpg';
            $candidates[] = $folderHint . '/' . $name . '.jpeg';
            $candidates[] = $folderHint . '/' . $name . '.png';
            $candidates[] = 'uploads/' . $name . '.jpg';
            $candidates[] = 'uploads/' . $name . '.png';

            // find best match by basename or containing name
            $best = null;
            foreach ($candidates as $cand) {
                if (Storage::disk('public')->exists($cand)) {
                    $best = $cand;
                    break;
                }
            }

            if (! $best) {
                // fuzzy search: find first file that contains the stem
                $stem = preg_replace('/[-_]?[0-9]+$/', '', pathinfo($name, PATHINFO_FILENAME));
                $found = $files->first(function ($f) use ($stem) {
                    $base = pathinfo($f, PATHINFO_FILENAME);
                    return stripos($base, $stem) !== false || stripos($stem, $base) !== false;
                });
                if ($found) {
                    $best = $found;
                }
            }

            if ($best) {
                $this->info("Will set thumbnail for [{$modelClass}] id={$rec->id} -> {$best}");
                if (! env('DRY_RUN', false)) {
                    $rec->thumbnail = $best;
                    $rec->save();
                }
            } else {
                $this->info("No candidate found for [{$modelClass}] id={$rec->id} (name={$rec->nama})");
            }
        }
    }

    protected function info($msg)
    {
        echo $msg . PHP_EOL;
    }
}
