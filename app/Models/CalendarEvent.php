<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CalendarEvent extends Model
{
    protected $table = 'calendar_events';

    protected $fillable = [
        'slug',
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

    protected static function booted()
    {
        static::creating(function ($event) {
            if (empty($event->slug)) {
                $slug = Str::slug($event->title ?? $event->judul ?? 'event');
                $count = 1;
                while (self::where('slug', $slug)->exists()) {
                    $slug = Str::slug($event->title ?? $event->judul ?? 'event') . '-' . $count++;
                }
                $event->slug = $slug;
            }
        });
    }

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
