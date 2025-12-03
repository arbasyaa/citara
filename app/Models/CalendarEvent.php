<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarEvent extends Model
{
    protected $table = 'calendar_events';

    protected $fillable = [
        'month',
        'category',
        'year',
        'start_date',
        'end_date',
        'date_range',
        'title',
        'location',
        'description',
        'image',
        'destinasi_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'year' => 'integer',
    ];

    public function getDateRangeAttribute($value)
    {
        if ($value) return $value;
        if ($this->start_date && $this->end_date) {
            return $this->start_date->format('j') . ' - ' . $this->end_date->translatedFormat('j F');
        }
        if ($this->start_date) {
            return $this->start_date->translatedFormat('j F');
        }
        return null;
    }

    public function destinasi(): BelongsTo
    {
        return $this->belongsTo(Destinasi::class, 'destinasi_id');
    }
}
