<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FotoDestinasiSeeder extends Seeder
{
    public function run(): void
    {
        $fotos = [
            [
                'id_destinasi' => 1,
                'url' => 'destinasi/teluk-penyu-1.jpg',
                'keterangan' => 'Pemandangan Pantai Teluk Penyu',
                'apakah_slider_utama' => true
            ],
            [
                'id_destinasi' => 2,
                'url' => 'destinasi/benteng-pendem-1.jpg',
                'keterangan' => 'Benteng Pendem dari udara',
                'apakah_slider_utama' => true
            ],
            [
                'id_destinasi' => 3,
                'url' => 'destinasi/widarapayung-1.jpg',
                'keterangan' => 'Sunset di Pantai Widarapayung',
                'apakah_slider_utama' => true
            ],
            [
                'id_destinasi' => 4,
                'url' => 'destinasi/cipendok-1.jpg',
                'keterangan' => 'Air Terjun Curug Cipendok',
                'apakah_slider_utama' => true
            ],
            [
                'id_destinasi' => 5,
                'url' => 'destinasi/batik-1.jpg',
                'keterangan' => 'Proses membatik di Kampoeng Batik',
                'apakah_slider_utama' => true
            ]
        ];

        foreach ($fotos as $foto) {
            \App\Models\FotoDestinasi::updateOrCreate([
                'id_destinasi' => $foto['id_destinasi'],
                'url' => $foto['url']
            ], $foto);
        }
    }
}
