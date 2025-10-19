<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transportasi;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TransportasiController extends Controller
{
    public function index(): View
    {
        $transportasi = Transportasi::paginate(10);
        return view('admin.transportasi.index', compact('transportasi'));
    }

    public function create(): View
    {
        return view('admin.transportasi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:Kereta Api,Bus,Pesawat,Transportasi Lokal',
            'deskripsi' => 'nullable|string',
            'info_rute' => 'nullable|string'
        ]);

        Transportasi::create($validated);

        return redirect()
            ->route('admin.transportasi.index')
            ->with('success', 'Transportasi berhasil ditambahkan');
    }

    public function edit(Transportasi $transportasi): View
    {
        return view('admin.transportasi.edit', compact('transportasi'));
    }

    public function update(Request $request, Transportasi $transportasi): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:Kereta Api,Bus,Pesawat,Transportasi Lokal',
            'deskripsi' => 'nullable|string',
            'info_rute' => 'nullable|string'
        ]);

        $transportasi->update($validated);

        return redirect()
            ->route('admin.transportasi.index')
            ->with('success', 'Transportasi berhasil diperbarui');
    }

    public function destroy(Transportasi $transportasi): RedirectResponse
    {
        $transportasi->delete();

        return redirect()
            ->route('admin.transportasi.index')
            ->with('success', 'Transportasi berhasil dihapus');
    }
}
