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
        'title_en',
        'location',
        'location_en',
        'description',
        'description_en',
        'image',
        'destinasi_id',
    ];

    /**
     * Get localized title based on current locale
     */
    public function getLocalizedTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'en' && !empty($this->title_en) ? $this->title_en : $this->title;
    }

    /**
     * Get localized description based on current locale
     */
    public function getLocalizedDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'en' && !empty($this->description_en) ? $this->description_en : $this->description;
    }

    /**
     * Get localized location based on current locale
     */
    public function getLocalizedLocationAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'en' && !empty($this->location_en) ? $this->location_en : $this->location;
    }

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
