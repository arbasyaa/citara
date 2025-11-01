<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class FotoDestinasi extends Model
{
    protected $table = 'foto_destinasi';

    protected $fillable = [
        'id_destinasi',
        'url',
        'keterangan',
        'apakah_slider_utama'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'apakah_slider_utama' => 'boolean'
    ];

    public function destinasi(): BelongsTo
    {
        return $this->belongsTo(Destinasi::class, 'id_destinasi');
    }

    /**
     * Boot method to add safety checks
     */
    protected static function booted()
    {
        // Before deleting a foto, ensure we're NOT accidentally deleting the parent destinasi
        static::deleting(function ($foto) {
            // This is just a safety log - the foto deletion should NEVER trigger destinasi deletion
            Log::info("Deleting FotoDestinasi #{$foto->id} for Destinasi #{$foto->id_destinasi}");
            
            // Count remaining photos (excluding this one being deleted)
            $remaining = self::where('id_destinasi', $foto->id_destinasi)
                ->where('id', '!=', $foto->id)
                ->count();
            
            if ($remaining === 0) {
                Log::warning("This is the last photo for Destinasi #{$foto->id_destinasi}. Destinasi will have no photos after deletion.");
            }
        });
    }
}

