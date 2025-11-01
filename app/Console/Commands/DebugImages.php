<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FotoDestinasi;
use App\Models\Akomodasi;
use App\Models\Transportasi;
use Illuminate\Support\Facades\Storage;

class DebugImages extends Command
{
    protected $signature = 'debug:images {--limit=10}';
    protected $description = 'Show sample image records and check filesystem presence';

    public function handle()
    {
        $limit = (int)$this->option('limit');

        $this->info("FotoDestinasi (first {$limit}):");
        FotoDestinasi::orderBy('id')->take($limit)->get()->each(function ($f) {
            $url = $f->url;
            $exists = $url ? (Storage::disk('public')->exists($url) ? 'exists' : 'missing') : 'no-path';
            $this->line("#{$f->id} -> {$url} -> " . Storage::url($url) . " -> {$exists}");
        });

        $this->info("\nAkomodasi (first {$limit}):");
        Akomodasi::orderBy('id')->take($limit)->get()->each(function ($a) {
            $thumb = $a->thumbnail;
            $exists = $thumb ? (Storage::disk('public')->exists($thumb) ? 'exists' : 'missing') : 'no-path';
            $this->line("#{$a->id} -> {$thumb} -> " . ($thumb ? Storage::url($thumb) : '-') . " -> {$exists}");
        });

        $this->info("\nTransportasi (first {$limit}):");
        Transportasi::orderBy('id')->take($limit)->get()->each(function ($t) {
            $thumb = $t->thumbnail;
            $exists = $thumb ? (Storage::disk('public')->exists($thumb) ? 'exists' : 'missing') : 'no-path';
            $this->line("#{$t->id} -> {$thumb} -> " . ($thumb ? Storage::url($thumb) : '-') . " -> {$exists}");
        });

        return 0;
    }
}
