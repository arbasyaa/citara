<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transportasi extends Model
{
    use \App\Traits\Sluggable;
    protected $table = 'transportasi';

        protected $fillable = [
        'nama',
        'nama_en',
        'slug',
        'tipe',
        'rute',
        'rute_en',
        'deskripsi',
        'deskripsi_en',
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

    /**
     * Get localized route based on current locale
     */
    public function getLocalizedRouteAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'en' && !empty($this->rute_en) ? $this->rute_en : $this->rute;
    }


    protected $enumJenis = [
        'Kereta Api',
        'Bus',
        'Pesawat',
        'Transportasi Lokal'
    ];
}
