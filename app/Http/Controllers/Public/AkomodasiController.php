<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Akomodasi;
use Illuminate\Http\Request;

class AkomodasiController extends Controller
{
    public function index(Request $request)
    {
        $items = Akomodasi::when($request->search, function ($q, $search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('tipe', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->orderByDesc('id')
            ->paginate(12);
        return view('public.akomodasi.index', compact('items'));
    }

    public function show(Akomodasi $akomodasi)
    {
        return view('public.akomodasi.show', compact('akomodasi'));
    }
}
