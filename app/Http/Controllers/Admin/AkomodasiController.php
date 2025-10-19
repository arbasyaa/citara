<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Akomodasi;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AkomodasiController extends Controller
{
    public function index(): View
    {
        $akomodasi = Akomodasi::paginate(10);
        return view('admin.akomodasi.index', compact('akomodasi'));
    }

    public function create(): View
    {
        return view('admin.akomodasi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:Hotel,Wisma,Villa,Homestay',
            'alamat' => 'required|string',
            'nomor_telepon' => 'nullable|string|max:20',
            'url_situs_web' => 'nullable|url|max:255'
        ]);

        Akomodasi::create($validated);

        return redirect()
            ->route('admin.akomodasi.index')
            ->with('success', 'Akomodasi berhasil ditambahkan');
    }

    public function edit(Akomodasi $akomodasi): View
    {
        return view('admin.akomodasi.edit', compact('akomodasi'));
    }

    public function update(Request $request, Akomodasi $akomodasi): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:Hotel,Wisma,Villa,Homestay',
            'alamat' => 'required|string',
            'nomor_telepon' => 'nullable|string|max:20',
            'url_situs_web' => 'nullable|url|max:255'
        ]);

        $akomodasi->update($validated);

        return redirect()
            ->route('admin.akomodasi.index')
            ->with('success', 'Akomodasi berhasil diperbarui');
    }

    public function destroy(Akomodasi $akomodasi): RedirectResponse
    {
        $akomodasi->delete();

        return redirect()
            ->route('admin.akomodasi.index')
            ->with('success', 'Akomodasi berhasil dihapus');
    }
}
