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
        // Cache reduced from 6 hours to 30 minutes for faster updates
        $featuredDestinations = Cache::remember("home.featured.{$locale}", now()->addMinutes(30), function () {
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
        // Cache reduced from 6 hours to 30 minutes for faster updates
        $popularDestinasi = Cache::remember("home.popular.{$locale}", now()->addMinutes(30), function () {
            try {
                $table = (new Destinasi())->getTable();
                if (Schema::hasColumn($table, 'is_popular')) {
                    return Destinasi::with(['wilayah', 'foto'])->where('is_popular', true)->take(8)->get();
                }
            } catch (\Exception $e) {
                // fall through
            }
            // Use latest() instead of inRandomOrder() for better performance
            // If you need variety, consider using is_popular flag or featured rotation
            return Destinasi::with(['wilayah', 'foto'])->latest()->take(8)->get();
        });

        // Recent Destinations
        $recentDestinasi = Cache::remember("home.recent.{$locale}", now()->addMinutes(15), function () {
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
        // Cache reduced from 12 hours to 1 hour for faster updates
        $wilayah = Cache::remember("home.wilayah.{$locale}", now()->addHour(), function () {
            try {
                return Wilayah::withCount('destinasi')->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        // Destinasi count (for hero stats)
        // Cache reduced from 6 hours to 30 minutes
        $destinasiCount = Cache::remember("home.destinasi_count.{$locale}", now()->addMinutes(30), function () {
            try { return Destinasi::count(); } catch (\Exception $e) { return 0; }
        });

        // Events (ordered by Indonesian month names)
        $events = Cache::remember("home.events.{$locale}", now()->addHour(), function () {
            try {
                return CalendarEvent::orderByRaw("FIELD(month, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        // Akomodasi and Transportasi small home lists
        $akomodasiHome = Cache::remember("home.akomodasi.{$locale}", now()->addHours(6), function () {
            try { return Akomodasi::orderByDesc('id')->take(6)->get(); } catch (\Exception $e) { return collect(); }
        });

        $transportasiHome = Cache::remember("home.transportasi.{$locale}", now()->addHours(6), function () {
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


