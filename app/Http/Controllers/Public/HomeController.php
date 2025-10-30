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

class HomeController extends Controller
{
    public function index(): View
    {
        // Prefer explicitly flagged featured destinasi if the column exists.
        // If the migration hasn't been run (column missing), fall back to the
        // previous behavior which used the slider foto.
        // Featured destinasi: strictly use flagged ones when the column exists.
        // If the migration hasn't been run, fall back to the legacy behavior
        // that uses slider photos.
        try {
            if (Schema::hasColumn((new Destinasi())->getTable(), 'is_featured')) {
                $featuredDestinations = Destinasi::with(['wilayah', 'foto'])
                    ->where('is_featured', true)
                    ->take(6)
                    ->get();
            } else {
                $featuredDestinations = Destinasi::with(['wilayah', 'foto'])
                    ->whereHas('foto', function ($query) {
                        $query->where('apakah_slider_utama', true);
                    })
                    ->take(6)
                    ->get();
            }
        } catch (\Exception $e) {
            // On any schema check failure, use legacy behavior so site remains functional.
            $featuredDestinations = Destinasi::with(['wilayah', 'foto'])
                ->whereHas('foto', function ($query) {
                    $query->where('apakah_slider_utama', true);
                })
                ->take(6)
                ->get();
        }

        // Include all wilayah and order by number of destinasi so newly created
        // wilayah (with zero destinasi) also appear on the homepage.
        $wilayah = Wilayah::withCount('destinasi')
            ->orderByDesc('destinasi_count')
            ->get();
            
        // Prefer explicitly flagged popular destinasi if the column exists;
        // otherwise pick random ones.
        // Popular destinasi: strictly show flagged popular ones when column exists.
        try {
            if (Schema::hasColumn((new Destinasi())->getTable(), 'is_popular')) {
                $popularDestinasi = Destinasi::with(['wilayah', 'foto'])
                    ->where('is_popular', true)
                    ->take(8)
                    ->get();
            } else {
                $popularDestinasi = Destinasi::with(['wilayah', 'foto'])
                    ->inRandomOrder()
                    ->take(8)
                    ->get();
            }
        } catch (\Exception $e) {
            // On schema check failure, use legacy randomized behavior.
            $popularDestinasi = Destinasi::with(['wilayah', 'foto'])
                ->inRandomOrder()
                ->take(8)
                ->get();
        }
            
        // Recent destinasi: strictly show recent highlighted destinasi when
        // the highlight columns exist. If the columns aren't present, fall
        // back to showing the latest destinasi.
        try {
            $table = (new Destinasi())->getTable();
            if (Schema::hasColumn($table, 'is_featured') || Schema::hasColumn($table, 'is_popular')) {
                $recentDestinasi = Destinasi::with(['wilayah', 'foto'])
                    ->where(function ($q) {
                        $q->where('is_featured', true)
                          ->orWhere('is_popular', true);
                    })
                    ->latest()
                    ->take(4)
                    ->get();
            } else {
                $recentDestinasi = Destinasi::with(['wilayah', 'foto'])
                    ->latest()
                    ->take(4)
                    ->get();
            }
        } catch (\Exception $e) {
            // On any schema check failure, show latest destinasi
            $recentDestinasi = Destinasi::with(['wilayah', 'foto'])
                ->latest()
                ->take(4)
                ->get();
        }

        // Get total destinasi count for stats
        $destinasiCount = Destinasi::count();

        // Get calendar events
        $events = CalendarEvent::orderByRaw("FIELD(month, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")->get();

        // Akomodasi and Transportasi for homepage cards
        try {
            $akomodasiHome = Akomodasi::orderByDesc('id')->take(6)->get();
        } catch (\Exception $e) {
            $akomodasiHome = collect();
        }

        try {
            $transportasiHome = Transportasi::orderByDesc('id')->take(6)->get();
        } catch (\Exception $e) {
            $transportasiHome = collect();
        }

        return view('public.home', compact('featuredDestinations', 'wilayah', 'popularDestinasi', 'recentDestinasi', 'destinasiCount', 'events', 'akomodasiHome', 'transportasiHome'));
    }
}
