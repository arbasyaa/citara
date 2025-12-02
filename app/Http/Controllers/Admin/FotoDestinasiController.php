<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;
use App\Models\FotoDestinasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FotoDestinasiController extends Controller
{
    public function index(Destinasi $destinasi): View
    {
        $foto = $destinasi->foto()->paginate(12);
        return view('admin.foto-destinasi.index', compact('destinasi', 'foto'));
    }

    public function create(Destinasi $destinasi): View
    {
        return view('admin.foto-destinasi.create', compact('destinasi'));
    }

    public function store(Request $request, Destinasi $destinasi): RedirectResponse
    {
        $validated = $request->validate([
            'foto' => 'required|image|max:2048',
            'keterangan' => 'nullable|string|max:255',
            'apakah_slider_utama' => 'boolean'
        ]);

        // Store on the public disk so it is served via /storage
        $path = $request->file('foto')->store('uploads/destinasi', 'public');
        
        // If this is set as main slider, unset others
        if ($validated['apakah_slider_utama']) {
            $destinasi->foto()->update(['apakah_slider_utama' => false]);
        }

        $destinasi->foto()->create([
            'url' => $path,
            'keterangan' => $validated['keterangan'] ?? null,
            'apakah_slider_utama' => $validated['apakah_slider_utama'] ?? false
        ]);

        return redirect()
            ->route('admin.foto-destinasi.index', $destinasi)
            ->with('success', 'Foto berhasil ditambahkan');
    }

    public function destroy(FotoDestinasi $fotoDestinasi): RedirectResponse
    {
        $destinasi = $fotoDestinasi->destinasi;
        
        // Delete the file
        if (!empty($fotoDestinasi->url)) {
            // Delete from the public disk if present
            try { 
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($fotoDestinasi->url)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($fotoDestinasi->url);
                }
            } catch (\Exception $e) {
                // ignore file deletion errors
            }
        }
        
        $fotoDestinasi->delete();

        return redirect()
            ->route('admin.foto-destinasi.index', $destinasi)
            ->with('success', 'Foto berhasil dihapus');
    }

    public function toggleMainSlider(FotoDestinasi $fotoDestinasi): RedirectResponse
    {
        $destinasi = $fotoDestinasi->destinasi;
        
        // If making this the main slider, unset others
        if (!$fotoDestinasi->apakah_slider_utama) {
            $destinasi->foto()->update(['apakah_slider_utama' => false]);
        }
        
        $fotoDestinasi->update([
            'apakah_slider_utama' => !$fotoDestinasi->apakah_slider_utama
        ]);

        return redirect()
            ->route('admin.foto-destinasi.index', $destinasi)
            ->with('success', 'Status slider utama berhasil diperbarui');
    }
}
