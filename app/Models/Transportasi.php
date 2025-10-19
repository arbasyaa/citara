<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transportasi extends Model
{
    protected $table = 'transportasi';

    protected $fillable = [
        'nama',
        'tipe',
        'deskripsi',
        'rute'
    ];


    protected $enumJenis = [
        'Kereta Api',
        'Bus',
        'Pesawat',
        'Transportasi Lokal'
    ];
}
