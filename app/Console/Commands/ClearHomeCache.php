<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearHomeCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-home';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear homepage cache for all locales';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $locales = ['en', 'id'];
        $keys = [
            'home.featured',
            'home.popular',
            'home.recent',
            'home.wilayah',
            'home.destinasi_count',
            'home.events',
            'home.akomodasi',
            'home.transportasi',
        ];

        $cleared = 0;
        
        foreach ($locales as $locale) {
            foreach ($keys as $key) {
                $fullKey = "{$key}.{$locale}";
                if (Cache::forget($fullKey)) {
                    $cleared++;
                    $this->info("✓ Cleared: {$fullKey}");
                }
            }
        }

        $this->newLine();
        $this->info("✓ Homepage cache cleared! ({$cleared} cache keys removed)");
        $this->comment('💡 Run this command after updating destinations, wilayah, events, akomodasi, or transportasi');
        
        return self::SUCCESS;
    }
}
