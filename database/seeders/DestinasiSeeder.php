<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DestinasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinasi = [
            [
                'id_wilayah' => 1, // Cilacap Selatan
                'nama' => 'Pantai Teluk Penyu',
                'slug' => 'pantai-teluk-penyu',
                'deskripsi' => 'Pantai Teluk Penyu adalah salah satu destinasi wisata populer di Cilacap. Pantai ini terletak di sebelah selatan Kota Cilacap dan menghadap langsung ke Samudera Hindia. Pengunjung dapat menikmati pemandangan laut yang indah, melihat aktivitas nelayan tradisional, dan mencicipi hidangan seafood segar di warung-warung sekitar pantai.',
                'alamat_lokasi' => 'Jl. Lingkar Teluk Penyu, Cilacap Selatan, Kabupaten Cilacap',
                'url_gmaps' => 'https://goo.gl/maps/example1'
            ],
            [
                'id_wilayah' => 1, // Cilacap Selatan
                'nama' => 'Benteng Pendem',
                'slug' => 'benteng-pendem',
                'deskripsi' => 'Benteng Pendem atau Benteng Klingker adalah benteng peninggalan Belanda yang dibangun pada tahun 1861. Benteng ini sempat terkubur pasir selama bertahun-tahun sebelum akhirnya dibersihkan dan dijadikan objek wisata sejarah. Pengunjung dapat menjelajahi lorong-lorong benteng dan melihat berbagai artefak bersejarah.',
                'alamat_lokasi' => 'Benteng, Cilacap Selatan, Kabupaten Cilacap',
                'url_gmaps' => 'https://goo.gl/maps/example2'
            ],
            [
                'id_wilayah' => 3, // Nusawungu
                'nama' => 'Pantai Widarapayung',
                'slug' => 'pantai-widarapayung',
                'deskripsi' => 'Pantai Widarapayung terkenal dengan pasir putihnya yang indah dan ombak yang cocok untuk berselancar. Pantai ini memiliki pemandangan sunset yang menakjubkan dan berbagai fasilitas wisata seperti gazebo, area camping, dan warung makan.',
                'alamat_lokasi' => 'Widarapayung, Binangun, Kabupaten Cilacap',
                'url_gmaps' => 'https://goo.gl/maps/example3'
            ],
            [
                'id_wilayah' => 5, // Majenang
                'nama' => 'Air Terjun Curug Cipendok',
                'slug' => 'air-terjun-curug-cipendok',
                'deskripsi' => 'Air Terjun Curug Cipendok adalah salah satu air terjun tertinggi di Jawa dengan ketinggian sekitar 92 meter. Terletak di kawasan hutan yang asri, air terjun ini dikelilingi oleh pemandangan alam yang menakjubkan dan udara yang sejuk.',
                'alamat_lokasi' => 'Cipendok, Majenang, Kabupaten Cilacap',
                'url_gmaps' => 'https://goo.gl/maps/example4'
            ],
            [
                'id_wilayah' => 2, // Cilacap Tengah
                'nama' => 'Kampoeng Batik Cilacap',
                'slug' => 'kampoeng-batik-cilacap',
                'deskripsi' => 'Kampoeng Batik Cilacap adalah pusat kerajinan batik khas Cilacap. Pengunjung dapat melihat proses pembuatan batik tradisional, mengikuti workshop membatik, dan membeli berbagai produk batik khas Cilacap.',
                'alamat_lokasi' => 'Jl. Batik, Cilacap Tengah, Kabupaten Cilacap',
                'url_gmaps' => 'https://goo.gl/maps/example5'
            ]
        ];

        foreach ($destinasi as $d) {
            \App\Models\Destinasi::create($d);
        }
    }
}
