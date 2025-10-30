<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Transportasi;

class TransportasiController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $items = Transportasi::when($request->search, function ($q, $search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('tipe', 'like', "%{$search}%")
                  ->orWhere('rute', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->orderByDesc('id')
            ->paginate(12);
        return view('public.transportasi.index', compact('items'));
    }

    public function show(Transportasi $transportasi)
    {
        return view('public.transportasi.show', compact('transportasi'));
    }
}
