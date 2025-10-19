<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;
use App\Models\Wilayah;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredDestinations = Destinasi::with(['wilayah', 'foto'])
            ->whereHas('foto', function ($query) {
                $query->where('apakah_slider_utama', true);
            })
            ->take(6)
            ->get();

        $wilayah = Wilayah::withCount('destinasi')
            ->having('destinasi_count', '>', 0)
            ->get();
            
        $popularDestinasi = Destinasi::with(['wilayah', 'foto'])
            ->inRandomOrder()
            ->take(8)
            ->get();
            
        $recentDestinasi = Destinasi::with(['wilayah', 'foto'])
            ->latest()
            ->take(4)
            ->get();

        return view('public.home', compact('featuredDestinations', 'wilayah', 'popularDestinasi', 'recentDestinasi'));
    }
}
