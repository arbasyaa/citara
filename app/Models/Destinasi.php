<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Destinasi extends Model
{
    protected $table = 'destinasi';

    protected $fillable = [
        'id_wilayah',
        'nama',
        'slug',
        'deskripsi',
        'alamat_lokasi',
        'url_gmaps',
        'is_popular',
        'is_featured',
        // timestamps handled by created_at / updated_at
    ];


    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }

    public function foto(): HasMany
    {
        return $this->hasMany(FotoDestinasi::class, 'id_destinasi');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug) && ! empty($model->nama)) {
                $base = Str::slug($model->nama);
                $slug = $base;
                $i = 1;
                while (self::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i;
                    $i++;
                }
                $model->slug = $slug;
            }
        });
    }
}
