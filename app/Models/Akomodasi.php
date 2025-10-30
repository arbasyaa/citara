<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akomodasi extends Model
{
    protected $table = 'akomodasi';

    protected $fillable = [
        'nama',
        'tipe',
        'deskripsi',
        'lokasi',
        'nomor_telepon',
        'url_situs_web',
        'thumbnail'
    ];


    protected $enumJenis = [
        'Hotel',
        'Wisma',
        'Villa',
        'Homestay'
    ];
}
