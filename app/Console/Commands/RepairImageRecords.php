<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FotoDestinasi;
use App\Models\Akomodasi;
use App\Models\Transportasi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RepairImageRecords extends Command
{
    protected $signature = 'images:repair-missing {--dry : Do not write changes}';
    protected $description = 'Repair FotoDestinasi entries that reference missing files (e.g., .gitignore) by finding best-matching files in storage';

    public function handle()
    {
        $dry = $this->option('dry');
        $this->info('Loading storage file index...');
        $files = Storage::disk('public')->allFiles();
        $allowedExt = ['jpg','jpeg','png','webp','gif','svg','bmp','avif'];
        $imageFiles = [];
        foreach ($files as $f) {
            $b = basename($f);
            if (str_starts_with($b, '.')) continue;
            $ext = strtolower(pathinfo($b, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedExt)) continue;
            $imageFiles[] = $f;
        }

        $this->info('Scanning FotoDestinasi for missing or .gitignore records...');
        $candidates = FotoDestinasi::where(function($q){
            $q->where('url', '.gitignore')->orWhereNull('url')->orWhere('url', '');
        })->orWhereRaw("NOT EXISTS (SELECT 1 FROM information_schema.tables WHERE table_name='foto_destinasi')");

        // Also include records where file does not exist or where url was set to .gitignore by a previous attempt
        $records = FotoDestinasi::orderBy('id')->get()->filter(function ($r) use ($imageFiles) {
            $url = $r->url;
            if (empty($url)) return true;
            if ($url === '.gitignore') return true;
            try { if (Storage::disk('public')->exists($url)) return false; } catch (\Exception $e) { /* continue */ }
            return true;
        });

        $this->info('Found ' . $records->count() . ' records to attempt repair');

        foreach ($records as $r) {
            $this->line("Record #{$r->id} (destinasi_id={$r->id_destinasi}) current url='{$r->url}'");
            $destName = optional($r->destinasi)->nama ?? '';
            $desc = $r->keterangan ?? '';
            $tokens = array_filter(array_unique(array_merge([
                Str::slug($destName),
                Str::slug($desc),
                'destinasi-' . ($r->id_destinasi ?? ''),
            ], explode('-', Str::slug($r->url ?? '')))));

            $best = null; $bestScore = 0;
            foreach ($imageFiles as $f) {
                $b = basename($f);
                $score = 0;
                foreach ($tokens as $t) {
                    if (!$t) continue;
                    if (stripos($b, $t) !== false) $score += 3;
                }
                // prefer files under destinasi folder
                if (stripos($f, 'destinasi/') !== false) $score += 2;
                // slight bonus for matching id
                if (!empty($r->id_destinasi) && stripos($b, (string)$r->id_destinasi) !== false) $score += 4;
                if ($score > $bestScore) { $bestScore = $score; $best = $f; }
            }

            if ($best && $bestScore > 0) {
                $this->line(" -> best match: {$best} (score={$bestScore})");
                if (!$dry) { $r->update(['url' => $best]); }
            } else {
                $this->line(' -> no good match found');
            }
        }

        $this->info('Done');
        return 0;
    }
}
