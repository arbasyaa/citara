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
        // Get available years from database
        $availableYears = CalendarEvent::whereNotNull('year')
            ->where('year', '!=', '')
            ->distinct()
            ->pluck('year')
            ->map(fn($y) => (int)$y)
            ->filter(fn($y) => $y > 2000 && $y < 2100)
            ->sort()
            ->values();
        
        if ($availableYears->isEmpty()) {
            $availableYears = collect([2025]); // default fallback
        }
        
        $events = CalendarEvent::with('destinasi:id,nama,slug,alamat_lokasi')
            ->orderByRaw("FIELD(month, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
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
                    'raw_month' => $event->month,
                    'year' => $event->year ?? 2025,
                    'category' => $event->category ?? 'festival',
                    'location' => $event->location ?? $event->lokasi,
                    'location_label' => $locationLabel,
                    'location_url' => $locationUrl,
                    'location_address' => $locationAddress,
                    'image' => $event->image ? ImageUrl::url($event->image) : null,
                ];
            })
            ->sortBy([
                ['month', 'asc'],
                ['id', 'asc']
            ])
            ->values();

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
            'availableYears' => $availableYears,
        ]);
    }

    public function show(CalendarEvent $event): View
    {
        $event->load('destinasi:id,nama,slug,alamat_lokasi');
        
        return view('public.events.show', [
            'event' => $event,
        ]);
    }
}
