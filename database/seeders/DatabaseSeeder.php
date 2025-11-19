<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user if not exists
        if (! \App\Models\User::where('email', 'admin@example.com')->exists()) {
            \App\Models\User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password')
            ]);
        }

        // Seed core content only if tables are empty to avoid clobbering imported data
        if (\Illuminate\Support\Facades\Schema::hasTable('wilayah') && \App\Models\Wilayah::count() === 0) {
            $this->call([WilayahSeeder::class]);
        }
        if (\Illuminate\Support\Facades\Schema::hasTable('destinasi') && \App\Models\Destinasi::count() === 0) {
            $this->call([DestinasiSeeder::class]);
        }
        if (\Illuminate\Support\Facades\Schema::hasTable('foto_destinasi') && \App\Models\FotoDestinasi::count() === 0) {
            $this->call([FotoDestinasiSeeder::class]);
        }

        // Admin-managed content: safe to seed if empty
        if (\Illuminate\Support\Facades\Schema::hasTable('services') && \App\Models\Service::count() === 0) {
            $this->call([\Database\Seeders\ServiceSeeder::class]);
        }
        if (\Illuminate\Support\Facades\Schema::hasTable('calendar_events') && \App\Models\CalendarEvent::count() === 0) {
            $this->call([\Database\Seeders\CalendarEventSeeder::class]);
        }
    }
}
