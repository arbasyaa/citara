<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CalendarEvent;

class CalendarEventSeeder extends Seeder
{
    public function run(): void
    {
        $months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        foreach (array_slice($months, 0, 6) as $i => $m) {
            CalendarEvent::create([
                'month' => $m,
                'date_range' => ($i+1) . ' - ' . ($i+3) . ' ' . $m,
                'title' => 'Event ' . ($i+1) . ' di ' . $m,
                'location' => 'Lokasi ' . ($i+1),
                'description' => 'Deskripsi acara untuk ' . $m,
                'image' => null,
            ]);
        }
    }
}
