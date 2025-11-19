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
            'tipe' => 'required|in:wisata,kuliner',
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
        'tipe' => 'required|in:wisata,kuliner',
        'deskripsi' => 'required|string',
        'alamat_lokasi' => 'required|string',
        'url_gmaps' => 'nullable|url|max:2048',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $validated['slug'] = Str::slug($validated['nama']);

    // Update data teks
    $destinasi->update($validated);

    // Upload gambar jika ada
    if ($request->hasFile('image')) {
        // pastikan disk public digunakan
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Simpan ke storage/app/public/destinasi
        $path = $file->storeAs('destinasi', $filename, 'public');

        // Simpan ke relasi foto_destinasi
        if (method_exists($destinasi, 'foto')) {
            $destinasi->foto()->create(['url' => $path]);
        }
    }

    return redirect()
        ->route('admin.destinasi.index')
        ->with('success', 'Destinasi wisata berhasil diperbarui');
}
    
}