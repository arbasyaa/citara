<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akomodasi extends Model
{
    use \App\Traits\Sluggable;
    protected $table = 'akomodasi';

    protected $fillable = [
        'nama',
        'slug',
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
