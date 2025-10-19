<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DestinasiController extends Controller
{
    public function index(): View
    {
        $destinasi = Destinasi::with('wilayah')
            ->withCount('foto')
            ->paginate(10);
        return view('admin.destinasi.index', compact('destinasi'));
    }

    public function create(): View
    {
        $wilayah = Wilayah::all();
        return view('admin.destinasi.create', compact('wilayah'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_wilayah' => 'required|exists:wilayah,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'alamat_lokasi' => 'required|string',
            'url_gmaps' => 'nullable|url|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        Destinasi::create($validated);

        return redirect()
            ->route('admin.destinasi.index')
            ->with('success', 'Destinasi wisata berhasil ditambahkan');
    }

    public function show(Destinasi $destinasi): View
    {
        $destinasi->load(['wilayah', 'foto']);
        return view('admin.destinasi.show', compact('destinasi'));
    }

    public function edit(Destinasi $destinasi): View
    {
        $wilayah = Wilayah::all();
        return view('admin.destinasi.edit', compact('destinasi', 'wilayah'));
    }

    public function update(Request $request, Destinasi $destinasi): RedirectResponse
    {
        $validated = $request->validate([
            'id_wilayah' => 'required|exists:wilayah,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'alamat_lokasi' => 'required|string',
            'url_gmaps' => 'nullable|url|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        $destinasi->update($validated);

        return redirect()
            ->route('admin.destinasi.index')
            ->with('success', 'Destinasi wisata berhasil diperbarui');
    }

    public function destroy(Destinasi $destinasi): RedirectResponse
    {
        $destinasi->delete();

        return redirect()
            ->route('admin.destinasi.index')
            ->with('success', 'Destinasi wisata berhasil dihapus');
    }
}
