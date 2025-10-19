<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class WilayahController extends Controller
{
    public function index(): View
    {
        $wilayah = Wilayah::withCount('destinasi')->paginate(10);
        return view('admin.wilayah.index', compact('wilayah'));
    }

    public function create(): View
    {
        return view('admin.wilayah.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        $validated['slug'] = Str::slug($validated['nama']);
        
        Wilayah::create($validated);

        return redirect()
            ->route('admin.wilayah.index')
            ->with('success', 'Wilayah berhasil ditambahkan');
    }

    public function show(Wilayah $wilayah): View
    {
        $wilayah->load(['destinasi' => fn($query) => $query->with('foto')]);
        return view('admin.wilayah.show', compact('wilayah'));
    }

    public function edit(Wilayah $wilayah): View
    {
        return view('admin.wilayah.edit', compact('wilayah'));
    }

    public function update(Request $request, Wilayah $wilayah): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        $wilayah->update($validated);

        return redirect()
            ->route('admin.wilayah.index')
            ->with('success', 'Wilayah berhasil diperbarui');
    }

    public function destroy(Wilayah $wilayah): RedirectResponse
    {
        $wilayah->delete();

        return redirect()
            ->route('admin.wilayah.index')
            ->with('success', 'Wilayah berhasil dihapus');
    }
}
