<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\Akomodasi;
use App\Models\Transportasi;

class BackfillSlugs extends Command
{
    protected $signature = 'slugs:backfill {--models=* : Specific models to backfill (akomodasi,transportasi)}';
    protected $description = 'Backfill slug columns for Akomodasi and Transportasi where slug is empty';

    public function handle()
    {
        $models = $this->option('models') ?: ['akomodasi','transportasi'];

        if (in_array('akomodasi', $models)) {
            $this->info('Backfilling Akomodasi...');
            Akomodasi::whereNull('slug')->orWhere('slug', '')->chunkById(100, function ($items) {
                foreach ($items as $item) {
                    $base = Str::slug($item->nama ?: 'akomodasi');
                    $slug = $base;
                    $i = 1;
                    while (Akomodasi::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                        $slug = $base . '-' . $i++;
                    }
                    $item->slug = $slug;
                    $item->save();
                    $this->line(" - Akomodasi #{$item->id} => {$slug}");
                }
            });
        }

        if (in_array('transportasi', $models)) {
            $this->info('Backfilling Transportasi...');
            Transportasi::whereNull('slug')->orWhere('slug', '')->chunkById(100, function ($items) {
                foreach ($items as $item) {
                    $base = Str::slug($item->nama ?: 'transportasi');
                    $slug = $base;
                    $i = 1;
                    while (Transportasi::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                        $slug = $base . '-' . $i++;
                    }
                    $item->slug = $slug;
                    $item->save();
                    $this->line(" - Transportasi #{$item->id} => {$slug}");
                }
            });
        }

        $this->info('Done backfilling slugs.');
        return 0;
    }
}
