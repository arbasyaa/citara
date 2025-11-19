<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackfillDestinasiTipeSeeder extends Seeder
{
    public function run(): void
    {
        if (Schema::hasTable('destinasi') && Schema::hasColumn('destinasi', 'tipe')) {
            // Update any null or empty tipe values to default 'wisata'
            DB::table('destinasi')
                ->whereNull('tipe')
                ->orWhere('tipe', '')
                ->update(['tipe' => 'wisata']);

            $updated = DB::table('destinasi')
                ->where('tipe', 'wisata')
                ->count();

            $this->command->info("Backfilled {$updated} destinasi records with default tipe='wisata'.");
        } else {
            $this->command->warn('Table destinasi or column tipe does not exist. Skipping backfill.');
        }
    }
}
