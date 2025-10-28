<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use App\Models\Wilayah;
use App\Models\Destinasi;
use App\Models\Akomodasi;
use App\Models\Transportasi;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminController extends Controller
{
    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $password = $request->input('password');
        $adminPassword = env('ADMIN_PASSWORD', 'changeme');
        if ($password === $adminPassword) {
            session(['is_admin' => true]);
            return redirect()->route('panel.dashboard');
        }
        return back()->withErrors(['password' => 'Invalid password']);
    }

    public function logout()
    {
        session()->forget('is_admin');
    return redirect()->route('panel.login');
    }

    public function dashboard()
    {
        $events = CalendarEvent::orderByRaw("FIELD(month, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")->get();
        return view('admin.dashboard', compact('events'));
    }

    // Services panel removed from lightweight panel. Use main /admin area for full service management.

    // Events CRUD
    public function eventsIndex()
    {
        $events = CalendarEvent::orderBy('id')->get();
    return view('admin.events.index', compact('events'));
    }

    public function eventsCreate()
    {
        return view('admin.events.create');
    }

    public function eventsStore(Request $request)
    {
        $data = $request->validate([
            'month' => 'required|string',
            'date_range' => 'nullable|string',
            'title' => 'required|string',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096'
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $data['image'] = $path;
        }
        CalendarEvent::create($data);
    return redirect()->route('panel.events.index')->with('success', 'Event created');
    }

    public function eventsEdit(CalendarEvent $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function eventsUpdate(Request $request, CalendarEvent $event)
    {
        $data = $request->validate([
            'month' => 'required|string',
            'date_range' => 'nullable|string',
            'title' => 'required|string',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096'
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $data['image'] = $path;
        }
        $event->update($data);
    return redirect()->route('panel.events.index')->with('success', 'Event updated');
    }

    public function eventsDestroy(CalendarEvent $event)
    {
        $event->delete();
    return redirect()->route('panel.events.index')->with('success', 'Event deleted');
    }

    // Wilayah CRUD for panel
    public function wilayahIndex()
    {
        $wilayah = Wilayah::withCount('destinasi')->paginate(15);
    return view('admin.wilayah.index', compact('wilayah'));
    }

    public function wilayahCreate()
    {
        return view('admin.wilayah.create');
    }

    public function wilayahStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'slug' => 'nullable|string',
            'deskripsi' => 'nullable|string'
        ]);
        $wilayah = Wilayah::create($data);

        // Create a placeholder destinasi so the wilayah appears in homepage lists
        // which may filter/display based on destinasi count in some views.
        try {
            Destinasi::create([
                'nama' => 'Destinasi Awal untuk ' . ($wilayah->nama ?? 'Wilayah'),
                'id_wilayah' => $wilayah->id,
                'deskripsi' => $wilayah->deskripsi ?? 'Placeholder destinasi dibuat otomatis saat wilayah dibuat.'
            ]);
        } catch (\Throwable $e) {
            // Non-fatal: if destinasi table or schema isn't present, ignore and continue.
        }

    return redirect()->route('panel.wilayah.index')->with('success', 'Wilayah created');
    }

    public function wilayahEdit(Wilayah $wilayah)
    {
    return view('admin.wilayah.edit', compact('wilayah'));
    }

    public function wilayahUpdate(Request $request, Wilayah $wilayah)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'slug' => 'nullable|string',
            'deskripsi' => 'nullable|string'
        ]);
        $wilayah->update($data);
    return redirect()->route('panel.wilayah.index')->with('success', 'Wilayah updated');
    }

    public function wilayahDestroy(Wilayah $wilayah)
    {
        $wilayah->delete();
    return redirect()->route('panel.wilayah.index')->with('success', 'Wilayah deleted');
    }

    // Destinasi CRUD for panel
    public function destinasiIndex()
    {
        $destinasi = Destinasi::with('wilayah')->paginate(15);
    return view('admin.destinasi.index', compact('destinasi'));
    }

    public function destinasiCreate()
    {
        return view('admin.destinasi.create');
    }

    public function destinasiStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'id_wilayah' => 'nullable|exists:wilayah,id',
            'deskripsi' => 'nullable|string',
            'alamat_lokasi' => 'nullable|string',
            'url_gmaps' => 'nullable|url',
            'is_highlight' => 'nullable|boolean',
            'image' => 'nullable|image|max:4096'
        ]);

        // Create destinasi first
        $highlight = !empty($data['is_highlight']);

        $payload = [
            'nama' => $data['nama'],
            'id_wilayah' => $data['id_wilayah'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'alamat_lokasi' => $data['alamat_lokasi'] ?? null,
            'url_gmaps' => $data['url_gmaps'] ?? null,
        ];

        try {
            if (Schema::hasColumn((new Destinasi())->getTable(), 'is_popular')) {
                $payload['is_popular'] = $highlight ? 1 : 0;
            }
            if (Schema::hasColumn((new Destinasi())->getTable(), 'is_featured')) {
                $payload['is_featured'] = $highlight ? 1 : 0;
            }
        } catch (\Exception $e) {
            // If Schema check fails, avoid setting the columns and continue.
        }

        $dest = Destinasi::create($payload);

        // If image uploaded, store it as FotoDestinasi
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            // create foto record
            $dest->foto()->create([
                'url' => $path,
                'keterangan' => null,
                'apakah_slider_utama' => true
            ]);
        }

    return redirect()->route('panel.destinasi.index')->with('success', 'Destinasi created');
    }

    public function destinasiEdit(Destinasi $destinasi)
    {
    return view('admin.destinasi.edit', compact('destinasi'));
    }

    public function destinasiUpdate(Request $request, Destinasi $destinasi)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'id_wilayah' => 'nullable|exists:wilayah,id',
            'deskripsi' => 'nullable|string',
            'alamat_lokasi' => 'nullable|string',
            'url_gmaps' => 'nullable|url',
            'is_highlight' => 'nullable|boolean',
            'image' => 'nullable|image|max:4096'
        ]);

        $highlight = !empty($data['is_highlight']);

        $payload = [
            'nama' => $data['nama'],
            'id_wilayah' => $data['id_wilayah'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'alamat_lokasi' => $data['alamat_lokasi'] ?? null,
            'url_gmaps' => $data['url_gmaps'] ?? null,
        ];

        try {
            if (Schema::hasColumn((new Destinasi())->getTable(), 'is_popular')) {
                $payload['is_popular'] = $highlight ? 1 : 0;
            }
            if (Schema::hasColumn((new Destinasi())->getTable(), 'is_featured')) {
                $payload['is_featured'] = $highlight ? 1 : 0;
            }
        } catch (\Exception $e) {
            // ignore and continue
        }

        $destinasi->update($payload);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $destinasi->foto()->create([
                'url' => $path,
                'keterangan' => null,
                'apakah_slider_utama' => false
            ]);
        }

    return redirect()->route('panel.destinasi.index')->with('success', 'Destinasi updated');
    }

    public function destinasiDestroy(Destinasi $destinasi)
    {
        $destinasi->delete();
    return redirect()->route('panel.destinasi.index')->with('success', 'Destinasi deleted');
    }

    // Akomodasi CRUD for panel
    public function akomodasiIndex()
    {
        if (! Schema::hasTable('akomodasi')) {
            // Return an empty paginator to keep the UI working when table isn't migrated.
            $items = [];
            $akomodasi = new LengthAwarePaginator($items, 0, 15);
            session()->flash('warning', 'Akomodasi table not found. Please run migrations to enable this panel.');
            return view('admin.akomodasi.index', compact('akomodasi'));
        }
        $akomodasi = Akomodasi::paginate(15);
    return view('admin.akomodasi.index', compact('akomodasi'));
    }

    public function akomodasiCreate()
    {
        return view('admin.akomodasi.create');
    }

    public function akomodasiStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'tipe' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'deskripsi' => 'nullable|string'
        ]);
        Akomodasi::create($data);
    return redirect()->route('panel.akomodasi.index')->with('success', 'Akomodasi created');
    }

    public function akomodasiEdit(Akomodasi $akomodasi)
    {
    return view('admin.akomodasi.edit', compact('akomodasi'));
    }

    public function akomodasiUpdate(Request $request, Akomodasi $akomodasi)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'tipe' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'deskripsi' => 'nullable|string'
        ]);
        $akomodasi->update($data);
    return redirect()->route('panel.akomodasi.index')->with('success', 'Akomodasi updated');
    }

    public function akomodasiDestroy(Akomodasi $akomodasi)
    {
        $akomodasi->delete();
    return redirect()->route('panel.akomodasi.index')->with('success', 'Akomodasi deleted');
    }

    // Transportasi CRUD for panel
    public function transportasiIndex()
    {
        if (! Schema::hasTable('transportasi')) {
            $items = [];
            $transportasi = new LengthAwarePaginator($items, 0, 15);
            session()->flash('warning', 'Transportasi table not found. Please run migrations to enable this panel.');
            return view('admin.transportasi.index', compact('transportasi'));
        }
        $transportasi = Transportasi::paginate(15);
    return view('admin.transportasi.index', compact('transportasi'));
    }

    public function transportasiCreate()
    {
        return view('admin.transportasi.create');
    }

    public function transportasiStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'tipe' => 'nullable|string',
            'rute' => 'nullable|string',
            'deskripsi' => 'nullable|string'
        ]);
        Transportasi::create($data);
    return redirect()->route('panel.transportasi.index')->with('success', 'Transportasi created');
    }

    public function transportasiEdit(Transportasi $transportasi)
    {
    return view('admin.transportasi.edit', compact('transportasi'));
    }

    public function transportasiUpdate(Request $request, Transportasi $transportasi)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'tipe' => 'nullable|string',
            'rute' => 'nullable|string',
            'deskripsi' => 'nullable|string'
        ]);
        $transportasi->update($data);
    return redirect()->route('panel.transportasi.index')->with('success', 'Transportasi updated');
    }

    public function transportasiDestroy(Transportasi $transportasi)
    {
        $transportasi->delete();
    return redirect()->route('panel.transportasi.index')->with('success', 'Transportasi deleted');
    }
}
