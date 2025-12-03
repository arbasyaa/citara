<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use App\Services\ImageUrl;
use Illuminate\View\View;

class EventController extends Controller
{
    public function calendar()
    {
        $events = CalendarEvent::with('destinasi:id,nama,slug,alamat_lokasi')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($event) {
                // Normalize month to numeric (1-12). Database may contain names or numbers.
                $monthVal = $event->month;
                $monthNumeric = null;
                if (is_numeric($monthVal)) {
                    $m = (int) $monthVal;
                    if ($m >= 1 && $m <= 12) {
                        $monthNumeric = $m;
                    }
                } else {
                    $search = strtolower(trim((string) $monthVal));
                    $monthsId = ['januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'];
                    $monthsEn = ['january','february','march','april','may','june','july','august','september','october','november','december'];
                    $pos = array_search($search, $monthsId, true);
                    if ($pos !== false) {
                        $monthNumeric = $pos + 1;
                    } else {
                        $pos = array_search($search, $monthsEn, true);
                        if ($pos !== false) {
                            $monthNumeric = $pos + 1;
                        }
                    }
                }

                $dest = $event->destinasi;
                $locationLabel = $dest?->nama ?? $event->location ?? null;
                $locationUrl = $dest ? route('destinasi.show', $dest->slug) : null;
                $locationAddress = $dest?->alamat_lokasi;

                return [
                    'id' => $event->id,
                    'slug' => $event->slug,
                    'title' => $event->title ?? $event->judul,
                    'description' => $event->description ?? $event->deskripsi,
                    'date_range' => $event->date_range ?? $event->tanggal,
                    'month' => $monthNumeric,
                    'monthName' => $monthNumeric ? ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][$monthNumeric - 1] : null,
                    'raw_month' => $event->month,
                    'year' => $event->year,
                    'category' => $event->category ?? 'festival',
                    'location' => $event->location ?? $event->lokasi,
                    'location_label' => $locationLabel,
                    'location_url' => $locationUrl,
                    'location_address' => $locationAddress,
                    'image' => $event->image ? ImageUrl::url($event->image) : null,
                ];
            });

        // Accept optional query parameters to open a specific year and month
        $requestedYear = request()->query('year');
        $requestedMonth = request()->query('month');

        // Normalize year (fallback to current year)
        $initialYear = $requestedYear && is_numeric($requestedYear) ? (int) $requestedYear : (int) date('Y');

        // Normalize month: accept numeric (1-12) or month name (Januari/January etc.)
        $initialMonth = null;
        if ($requestedMonth) {
            // If numeric-like
            if (is_numeric($requestedMonth)) {
                $m = (int) $requestedMonth;
                if ($m >= 1 && $m <= 12) {
                    $initialMonth = $m;
                }
            } else {
                // Try to match by month name (both English and Indonesian)
                $monthsId = ['januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'];
                $monthsEn = ['january','february','march','april','may','june','july','august','september','october','november','december'];
                $search = strtolower(trim($requestedMonth));
                $pos = array_search($search, $monthsId, true);
                if ($pos !== false) {
                    $initialMonth = $pos + 1;
                } else {
                    $pos = array_search($search, $monthsEn, true);
                    if ($pos !== false) {
                        $initialMonth = $pos + 1;
                    }
                }
            }
        }

        return view('public.events.calendar', [
            'events' => $events,
            'initialYear' => $initialYear,
            'initialMonth' => $initialMonth,
        ]);
    }

    public function show(string $slug): View
    {
        $calendarEvent = CalendarEvent::with('destinasi:id,nama,slug,alamat_lokasi,url_gmaps')
            ->where('slug', $slug)
            ->firstOrFail();

        // Normalize month
        $monthVal = $calendarEvent->month;
        $monthNumeric = null;
        $monthName = null;
        
        if (is_numeric($monthVal)) {
            $m = (int) $monthVal;
            if ($m >= 1 && $m <= 12) {
                $monthNumeric = $m;
                $monthsId = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                $monthName = $monthsId[$m - 1];
            }
        } else {
            $search = strtolower(trim((string) $monthVal));
            $monthsId = ['januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'];
            $monthsIdCap = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            $pos = array_search($search, $monthsId, true);
            if ($pos !== false) {
                $monthNumeric = $pos + 1;
                $monthName = $monthsIdCap[$pos];
            }
        }

        $dest = $calendarEvent->destinasi;
        $locationLabel = $dest?->nama ?? $calendarEvent->location ?? null;
        $locationUrl = $dest?->url_gmaps ?? null;
        $locationAddress = $dest?->alamat_lokasi ?? $calendarEvent->location;

        $event = [
            'id' => $calendarEvent->id,
            'slug' => $calendarEvent->slug,
            'title' => $calendarEvent->title ?? $calendarEvent->judul,
            'description' => $calendarEvent->description ?? $calendarEvent->deskripsi,
            'date_range' => $calendarEvent->date_range ?? $calendarEvent->tanggal,
            'month' => $monthNumeric,
            'monthName' => $monthName,
            'year' => $calendarEvent->year,
            'category' => $calendarEvent->category ?? 'festival',
            'location' => $calendarEvent->location ?? $calendarEvent->lokasi,
            'locationLabel' => $locationLabel,
            'locationUrl' => $locationUrl,
            'locationAddress' => $locationAddress,
            'image' => $calendarEvent->image ? ImageUrl::url($calendarEvent->image) : null,
        ];

        // Get related events from same category
        $relatedEvents = CalendarEvent::where('category', $calendarEvent->category)
            ->where('id', '!=', $calendarEvent->id)
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($evt) {
                return [
                    'id' => $evt->id,
                    'slug' => $evt->slug,
                    'title' => $evt->title ?? $evt->judul,
                    'date_range' => $evt->date_range ?? $evt->tanggal,
                    'category' => $evt->category ?? 'festival',
                    'image' => $evt->image ? ImageUrl::url($evt->image) : null,
                ];
            });

        return view('public.events.show', [
            'event' => $event,
            'relatedEvents' => $relatedEvents,
        ]);
    }
}
