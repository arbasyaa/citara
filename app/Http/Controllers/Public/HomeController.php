<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;
use Illuminate\Support\Facades\Schema;
use App\Models\Wilayah;
use App\Models\CalendarEvent;
use App\Models\Akomodasi;
use App\Models\Transportasi;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(): View
    {
        $locale = app()->getLocale();

        // Featured Destinations (prefer admin-flagged if column exists)
        $featuredDestinations = Cache::remember("home.featured.{$locale}", now()->addMinutes(10), function () {
            try {
                $table = (new Destinasi())->getTable();
                if (Schema::hasColumn($table, 'is_featured')) {
                    return Destinasi::with(['wilayah', 'foto'])->where('is_featured', true)->take(6)->get();
                }
            } catch (\Exception $e) {
                // fall through to legacy behavior
            }
            // fallback: prefer destinasi that have a utama photo, but include others if not enough
            $withUtama = Destinasi::with(['wilayah', 'foto'])->whereHas('foto', function ($q) {
                $q->where('apakah_slider_utama', true);
            })->take(6)->get();

            if ($withUtama->count() >= 6) {
                return $withUtama;
            }

            // if fewer than desired, include additional destinasi (without photos) to fill the slots
            $ids = $withUtama->pluck('id')->toArray();
            $extra = Destinasi::with(['wilayah', 'foto'])->whereNotIn('id', $ids)->take(6 - count($ids))->get();
            return $withUtama->merge($extra);
        });

        // Popular Destinations (prefer is_popular when available)
        $popularDestinasi = Cache::remember("home.popular.{$locale}", now()->addMinutes(10), function () {
            try {
                $table = (new Destinasi())->getTable();
                if (Schema::hasColumn($table, 'is_popular')) {
                    return Destinasi::with(['wilayah', 'foto'])->where('is_popular', true)->take(8)->get();
                }
            } catch (\Exception $e) {
                // fall through
            }
            return Destinasi::with(['wilayah', 'foto'])->inRandomOrder()->take(8)->get();
        });

        // Recent Destinations
        $recentDestinasi = Cache::remember("home.recent.{$locale}", now()->addMinutes(10), function () {
            try {
                $table = (new Destinasi())->getTable();
                if (Schema::hasColumn($table, 'is_featured') || Schema::hasColumn($table, 'is_popular')) {
                    return Destinasi::with(['wilayah', 'foto'])->where(function ($q) {
                        $q->where('is_featured', true)->orWhere('is_popular', true);
                    })->latest()->take(4)->get();
                }
            } catch (\Exception $e) {
                // fall through
            }
            return Destinasi::with(['wilayah', 'foto'])->latest()->take(4)->get();
        });

        // Regions / Wilayah
        $wilayah = Cache::remember("home.wilayah.{$locale}", now()->addMinutes(10), function () {
            try {
                return Wilayah::withCount('destinasi')->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        // Destinasi count (for hero stats)
        $destinasiCount = Cache::remember("home.destinasi_count.{$locale}", now()->addMinutes(10), function () {
            try { return Destinasi::count(); } catch (\Exception $e) { return 0; }
        });

        // Events (ordered by Indonesian month names)
        $events = Cache::remember("home.events.{$locale}", now()->addMinutes(10), function () {
            try {
                return CalendarEvent::orderByRaw("FIELD(month, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        // Akomodasi and Transportasi small home lists
        $akomodasiHome = Cache::remember("home.akomodasi.{$locale}", now()->addMinutes(10), function () {
            try { return Akomodasi::orderByDesc('id')->take(6)->get(); } catch (\Exception $e) { return collect(); }
        });

        $transportasiHome = Cache::remember("home.transportasi.{$locale}", now()->addMinutes(10), function () {
            try { return Transportasi::orderByDesc('id')->take(6)->get(); } catch (\Exception $e) { return collect(); }
        });

        return view('public.home', compact(
            'featuredDestinations',
            'popularDestinasi',
            'recentDestinasi',
            'wilayah',
            'destinasiCount',
            'events',
            'akomodasiHome',
            'transportasiHome'
        ));
    }
}


