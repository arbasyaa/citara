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
        // Create admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);

        $this->call([
            WilayahSeeder::class,
            DestinasiSeeder::class,
            FotoDestinasiSeeder::class
        ]);

        // Additional seeders for admin-managed content
        $this->call([
            \Database\Seeders\ServiceSeeder::class,
            \Database\Seeders\CalendarEventSeeder::class,
        ]);
    }
}
