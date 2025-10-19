<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinasiController extends Controller
{
    public function index(Request $request): View
    {
        $destinasi = Destinasi::with(['wilayah', 'foto'])
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->paginate(12);

        return view('public.destinasi.index', compact('destinasi'));
    }

    public function show(Destinasi $destinasi): View
    {
        $destinasi->load(['wilayah', 'foto']);
        
        return view('public.destinasi.show', compact('destinasi'));
    }

    public function byWilayah(Wilayah $wilayah): View
    {
        $destinasi = $wilayah->destinasi()
            ->with('foto')
            ->paginate(12);

        return view('public.destinasi.by-wilayah', compact('wilayah', 'destinasi'));
    }
}
