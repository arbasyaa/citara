<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transportasi extends Model
{
    use \App\Traits\Sluggable;
    protected $table = 'transportasi';

    protected $fillable = [
        'nama',
        'slug',
        'tipe',
        'deskripsi',
        'rute',
        'thumbnail'
    ];


    protected $enumJenis = [
        'Kereta Api',
        'Bus',
        'Pesawat',
        'Transportasi Lokal'
    ];
}
