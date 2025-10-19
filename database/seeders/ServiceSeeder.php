<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::create([
            'title' => 'Informasi Wisata',
            'description' => 'Dapatkan informasi lengkap tentang atraksi dan jadwal.',
            'link' => '#',
            'icon' => 'info',
            'image' => null,
        ]);

        Service::create([
            'title' => 'Pemandu Lokal',
            'description' => 'Pemandu lokal berpengalaman siap menemani tur Anda.',
            'link' => '#',
            'icon' => 'guide',
            'image' => null,
        ]);

        Service::create([
            'title' => 'Transportasi',
            'description' => 'Sewa kendaraan untuk perjalanan nyaman.',
            'link' => '#',
            'icon' => 'car',
            'image' => null,
        ]);
    }
}
