<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
