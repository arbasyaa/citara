<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    
    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        // timestamps handled by created_at / updated_at
    ];


    public function destinasi(): HasMany
    {
        return $this->hasMany(Destinasi::class, 'id_wilayah');
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
