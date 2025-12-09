<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akomodasi extends Model
{
    use \App\Traits\Sluggable;
    protected $table = 'akomodasi';

    protected $fillable = [
        'nama',
        'nama_en',
        'slug',
        'tipe',
        'lokasi',
        'nomor_telepon',
        'deskripsi',
        'deskripsi_en',
        'url_situs_web',
        'image',
    ];

    /**
     * Get localized name based on current locale
     */
    public function getLocalizedNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'en' && !empty($this->nama_en) ? $this->nama_en : $this->nama;
    }

    /**
     * Get localized description based on current locale
     */
    public function getLocalizedDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'en' && !empty($this->deskripsi_en) ? $this->deskripsi_en : $this->deskripsi;
    }


    protected $enumJenis = [
        'Hotel',
        'Wisma',
        'Villa',
        'Homestay'
    ];
}
