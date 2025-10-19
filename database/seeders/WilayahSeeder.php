<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wilayah = [
            [
                'nama' => 'Cilacap Selatan',
                'slug' => 'cilacap-selatan',
                'deskripsi' => 'Wilayah pesisir Cilacap dengan pantai-pantai indah dan pelabuhan Tanjung Intan'
            ],
            [
                'nama' => 'Cilacap Tengah',
                'slug' => 'cilacap-tengah',
                'deskripsi' => 'Pusat kota Cilacap dengan berbagai destinasi kuliner dan tempat bersejarah'
            ],
            [
                'nama' => 'Nusawungu',
                'slug' => 'nusawungu',
                'deskripsi' => 'Kawasan pantai eksotis dengan pemandangan alam yang menakjubkan'
            ],
            [
                'nama' => 'Kesugihan',
                'slug' => 'kesugihan',
                'deskripsi' => 'Daerah dengan kekayaan budaya dan wisata religi yang menarik'
            ],
            [
                'nama' => 'Majenang',
                'slug' => 'majenang',
                'deskripsi' => 'Wilayah pegunungan dengan wisata alam dan air terjun yang memukau'
            ]
        ];

        foreach ($wilayah as $w) {
            \App\Models\Wilayah::create($w);
        }
    }
}
