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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Lightweight destinasi search for admin combobox
    public function destinasiSearch(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $limit = (int) $request->query('limit', 20);
        $limit = $limit > 0 && $limit <= 50 ? $limit : 20;
        $query = Destinasi::query();
        if ($q !== '') {
            $query->where(function($b) use ($q){
                $b->where('nama', 'like', "%{$q}%")
                  ->orWhere('alamat_lokasi', 'like', "%{$q}%");
            });
        }
        $items = $query->orderBy('nama')->limit($limit)->get(['id','nama','alamat_lokasi']);
        return response()->json([
            'items' => $items,
        ]);
    }
    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'], 
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            
            if ($user->role === 'admin') { 
                $request->session()->regenerate();
                return redirect()->intended(route('panel.dashboard'));
            }

            Auth::guard('admin')->logout();
            return back()->withErrors(['email' => 'Akses ditolak. Anda bukan Administrator.']);
        }

        return back()->withErrors(['email' => 'Email atau Kata Sandi tidak valid.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

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
        $events = CalendarEvent::with('destinasi:id,nama,slug')
            ->orderBy('id')
            ->get();

        return view('admin.events.index', compact('events'));
    }

    public function eventsCreate()
    {
        $destinasiList = Destinasi::orderBy('nama')->get(['id', 'nama', 'alamat_lokasi']);

        return view('admin.events.create', compact('destinasiList'));
    }

    public function eventsStore(Request $request)
    {
        $data = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'category' => 'required|in:festival,workshop,pameran',
            'year' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'date_range' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096'
        ]);
        
        // Sanitize description HTML
        if (isset($data['description'])) {
            $data['description'] = strip_tags($data['description'], '<p><br><strong><em><ul><ol><li>');
        }
        
        // Convert numeric month to Indonesian month name for storage
        $monthNames = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        if (isset($data['month']) && is_numeric($data['month'])) {
            $data['month'] = $monthNames[(int)$data['month']] ?? $data['month'];
        }
        
        // Derive year if not provided
        if (empty($data['year'])) {
            if (!empty($data['start_date'])) {
                $data['year'] = (int) date('Y', strtotime($data['start_date']));
            } elseif (!empty($data['end_date'])) {
                $data['year'] = (int) date('Y', strtotime($data['end_date']));
            }
        }
        // Generate date_range if not provided but dates exist
        if (empty($data['date_range'])) {
            if (!empty($data['start_date']) && !empty($data['end_date'])) {
                $data['date_range'] = date('j', strtotime($data['start_date'])) . ' - ' . date('j F', strtotime($data['end_date']));
            } elseif (!empty($data['start_date'])) {
                $data['date_range'] = date('j F', strtotime($data['start_date']));
            }
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            // Validate actual image content
            $imageInfo = @getimagesize($file->path());
            if (!$imageInfo) {
                return back()->withErrors(['image' => 'File is not a valid image'])->withInput();
            }
            
            // Generate unique filename to prevent overwrite
            $filename = uniqid() . '_' . time() . '.' . $file->extension();
            $path = $file->storeAs('uploads', $filename, 'public');
            $data['image'] = $path;
        }
        CalendarEvent::create($data);
        // Invalidate home caches for all locales
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.events.{$loc}");
            Cache::forget("home.featured.{$loc}");
            Cache::forget("home.popular.{$loc}");
            Cache::forget("home.recent.{$loc}");
        }
    return redirect()->route('panel.events.index')->with('success', 'Event created');
    }

    public function eventsEdit(CalendarEvent $event)
    {
        $destinasiList = Destinasi::orderBy('nama')->get(['id', 'nama', 'alamat_lokasi']);

        return view('admin.events.edit', compact('event', 'destinasiList'));
    }

    public function eventsUpdate(Request $request, CalendarEvent $event)
    {
        $data = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'category' => 'required|in:festival,workshop,pameran',
            'year' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'date_range' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096'
        ]);
        
        // Sanitize description HTML
        if (isset($data['description'])) {
            $data['description'] = strip_tags($data['description'], '<p><br><strong><em><ul><ol><li>');
        }
        
        // Convert numeric month to Indonesian month name
        $monthNames = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        if (isset($data['month']) && is_numeric($data['month'])) {
            $data['month'] = $monthNames[(int)$data['month']] ?? $data['month'];
        }
        
        if (empty($data['year'])) {
            if (!empty($data['start_date'])) {
                $data['year'] = (int) date('Y', strtotime($data['start_date']));
            } elseif (!empty($data['end_date'])) {
                $data['year'] = (int) date('Y', strtotime($data['end_date']));
            }
        }
        if (empty($data['date_range'])) {
            if (!empty($data['start_date']) && !empty($data['end_date'])) {
                $data['date_range'] = date('j', strtotime($data['start_date'])) . ' - ' . date('j F', strtotime($data['end_date']));
            } elseif (!empty($data['start_date'])) {
                $data['date_range'] = date('j F', strtotime($data['start_date']));
            }
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            // Validate actual image content
            $imageInfo = @getimagesize($file->path());
            if (!$imageInfo) {
                return back()->withErrors(['image' => 'File is not a valid image'])->withInput();
            }
            
            // Generate unique filename to prevent overwrite
            $filename = uniqid() . '_' . time() . '.' . $file->extension();
            $path = $file->storeAs('uploads', $filename, 'public');
            $data['image'] = $path;
        }
        $event->update($data);
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.events.{$loc}");
            Cache::forget("home.featured.{$loc}");
            Cache::forget("home.popular.{$loc}");
            Cache::forget("home.recent.{$loc}");
        }
    return redirect()->route('panel.events.index')->with('success', 'Event updated');
    }

    public function eventsDestroy(CalendarEvent $event)
    {
        $event->delete();
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.events.{$loc}");
            Cache::forget("home.featured.{$loc}");
            Cache::forget("home.popular.{$loc}");
            Cache::forget("home.recent.{$loc}");
        }
    return redirect()->route('panel.events.index')->with('success', 'Event deleted');
    }

    // Wilayah CRUD for panel
    public function wilayahIndex(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $per = (int) $request->query('per_page', 15);
        $per = $per > 0 && $per <= 200 ? $per : 15;

        $query = Wilayah::withCount('destinasi');
        if ($q !== '') {
            $query->where(function ($b) use ($q) {
                $b->where('nama', 'like', "%{$q}%")->orWhere('slug', 'like', "%{$q}%");
            });
        }

        $wilayah = $query->orderBy('nama')->paginate($per)->appends($request->except('page'));
        return view('admin.wilayah.index', compact('wilayah', 'q'));
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

        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.wilayah.{$loc}");
            Cache::forget("home.featured.{$loc}");
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
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.wilayah.{$loc}");
            Cache::forget("home.featured.{$loc}");
        }
    return redirect()->route('panel.wilayah.index')->with('success', 'Wilayah updated');
    }

    public function wilayahDestroy(Wilayah $wilayah)
    {
        $wilayah->delete();
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.wilayah.{$loc}");
            Cache::forget("home.featured.{$loc}");
        }
    return redirect()->route('panel.wilayah.index')->with('success', 'Wilayah deleted');
    }

    // Destinasi CRUD for panel
    public function destinasiIndex(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $tipe = $request->query('tipe', '');
        $per = (int) $request->query('per_page', 15);
        $per = $per > 0 && $per <= 200 ? $per : 15;

        $query = Destinasi::with('wilayah');
        if ($q !== '') {
            $query->where(function ($b) use ($q) {
                $b->where('nama', 'like', "%{$q}%")
                  ->orWhere('slug', 'like', "%{$q}%");
            });
        }
        if ($tipe !== '' && in_array($tipe, ['wisata', 'kuliner'])) {
            $query->where('tipe', $tipe);
        }

        $destinasi = $query->orderBy('nama')->paginate($per)->appends($request->except('page'));
        return view('admin.destinasi.index', compact('destinasi', 'q', 'tipe'));
    }

    public function destinasiCreate()
    {
        return view('admin.destinasi.create');
    }

    public function destinasiStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'tipe' => 'required|in:wisata,kuliner',
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
            'tipe' => $data['tipe'],
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
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.featured.{$loc}");
            Cache::forget("home.popular.{$loc}");
            Cache::forget("home.recent.{$loc}");
            Cache::forget("home.destinasi_count.{$loc}");
        }

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
            'tipe' => 'required|in:wisata,kuliner',
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
            'tipe' => $data['tipe'],
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
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.featured.{$loc}");
            Cache::forget("home.popular.{$loc}");
            Cache::forget("home.recent.{$loc}");
            Cache::forget("home.destinasi_count.{$loc}");
        }

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
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.featured.{$loc}");
            Cache::forget("home.popular.{$loc}");
            Cache::forget("home.recent.{$loc}");
            Cache::forget("home.destinasi_count.{$loc}");
        }
    return redirect()->route('panel.destinasi.index')->with('success', 'Destinasi deleted');
    }

    /**
     * Remove a photo attached to a destinasi from the panel edit screen.
     * IMPORTANT: This ONLY deletes the photo, NOT the destinasi record.
     */
    public function destinasiPhotoDestroy(Destinasi $destinasi, \App\Models\FotoDestinasi $foto)
    {
        // ensure photo belongs to destinasi
        if ($foto->id_destinasi != $destinasi->id) {
            abort(404);
        }

        // Store destinasi ID to verify it still exists after photo deletion
        $destinasiId = $destinasi->id;
        $remainingPhotos = $destinasi->foto()->count() - 1; // Count after this deletion

        try {
            if (!empty($foto->url) && Storage::disk('public')->exists($foto->url)) {
                Storage::disk('public')->delete($foto->url);
            }
        } catch (\Exception $e) {
            // ignore storage deletion errors, continue with DB deletion
        }

        // Delete ONLY the foto record, not the destinasi
        $foto->delete();

        // Verify destinasi still exists (safety check)
        $destinasiStillExists = Destinasi::where('id', $destinasiId)->exists();
        if (!$destinasiStillExists) {
            Log::error("CRITICAL: Destinasi #{$destinasiId} was deleted after removing photo #{$foto->id}. This should NOT happen!");
            return redirect()->route('panel.destinasi.index')->with('error', 'Warning: Destinasi was unexpectedly deleted.');
        }

        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.featured.{$loc}");
            Cache::forget("home.popular.{$loc}");
            Cache::forget("home.recent.{$loc}");
        }

        $message = $remainingPhotos > 0 
            ? "Foto dihapus. {$remainingPhotos} foto tersisa." 
            : "Foto terakhir dihapus. Destinasi tetap ada tanpa foto.";

        return redirect()->route('panel.destinasi.edit', $destinasiId)->with('success', $message);
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
            'deskripsi' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:4096',
            'slug' => 'nullable|string|max:191'
        ]);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            try {
                if (class_exists('Intervention\\Image\\ImageManagerStatic')) {
                    $img = app('image')->make($file->getRealPath());
                    // create optimized thumb
                    $imgThumb = $img->fit(400, 300, function ($constraint) { $constraint->upsize(); });
                    $thumbPath = 'uploads/akomodasi/thumb-' . time() . '-' . $file->getClientOriginalName();
                    Storage::disk('public')->put($thumbPath, (string) $imgThumb->encode('jpg', 80));
                    $data['thumbnail'] = $thumbPath;
                } else {
                    $path = $file->store('uploads/akomodasi', 'public');
                    $data['thumbnail'] = $path;
                }
            } catch (\Exception $e) {
                $path = $file->store('uploads/akomodasi', 'public');
                $data['thumbnail'] = $path;
            }
        }

        // slug will be generated by model if empty; allow manual override
        if ($request->filled('slug')) {
            $data['slug'] = $request->input('slug');
        }

        Akomodasi::create($data);
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.akomodasi.{$loc}");
            Cache::forget("home.featured.{$loc}");
        }
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
            'deskripsi' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:4096',
            'slug' => 'nullable|string|max:191'
        ]);
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            try {
                if (class_exists('Intervention\\Image\\ImageManagerStatic')) {
                    $img = app('image')->make($file->getRealPath());
                    $imgThumb = $img->fit(400, 300, function ($constraint) { $constraint->upsize(); });
                    $thumbPath = 'uploads/akomodasi/thumb-' . time() . '-' . $file->getClientOriginalName();
                    Storage::disk('public')->put($thumbPath, (string) $imgThumb->encode('jpg', 80));
                    $data['thumbnail'] = $thumbPath;
                } else {
                    $path = $file->store('uploads/akomodasi', 'public');
                    $data['thumbnail'] = $path;
                }
            } catch (\Exception $e) {
                $path = $file->store('uploads/akomodasi', 'public');
                $data['thumbnail'] = $path;
            }
        }
        if ($request->filled('slug')) {
            $data['slug'] = $request->input('slug');
        }
        $akomodasi->update($data);
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.akomodasi.{$loc}");
            Cache::forget("home.featured.{$loc}");
        }
    return redirect()->route('panel.akomodasi.index')->with('success', 'Akomodasi updated');
    }

    public function akomodasiDestroy(Akomodasi $akomodasi)
    {
        $akomodasi->delete();
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.akomodasi.{$loc}");
            Cache::forget("home.featured.{$loc}");
        }
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
            'deskripsi' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:4096',
            'slug' => 'nullable|string|max:191'
        ]);
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            try {
                if (class_exists('Intervention\\Image\\ImageManagerStatic')) {
                    $img = app('image')->make($file->getRealPath());
                    $imgThumb = $img->fit(400, 300, function ($constraint) { $constraint->upsize(); });
                    $thumbPath = 'uploads/transportasi/thumb-' . time() . '-' . $file->getClientOriginalName();
                    Storage::disk('public')->put($thumbPath, (string) $imgThumb->encode('jpg', 80));
                    $data['thumbnail'] = $thumbPath;
                } else {
                    $path = $file->store('uploads/transportasi', 'public');
                    $data['thumbnail'] = $path;
                }
            } catch (\Exception $e) {
                $path = $file->store('uploads/transportasi', 'public');
                $data['thumbnail'] = $path;
            }
        }
        if ($request->filled('slug')) {
            $data['slug'] = $request->input('slug');
        }
        Transportasi::create($data);
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.transportasi.{$loc}");
            Cache::forget("home.featured.{$loc}");
        }
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
            'deskripsi' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:4096',
            'slug' => 'nullable|string|max:191'
        ]);
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            try {
                if (class_exists('Intervention\\Image\\ImageManagerStatic')) {
                    $img = app('image')->make($file->getRealPath());
                    $imgThumb = $img->fit(400, 300, function ($constraint) { $constraint->upsize(); });
                    $thumbPath = 'uploads/transportasi/thumb-' . time() . '-' . $file->getClientOriginalName();
                    Storage::disk('public')->put($thumbPath, (string) $imgThumb->encode('jpg', 80));
                    $data['thumbnail'] = $thumbPath;
                } else {
                    $path = $file->store('uploads/transportasi', 'public');
                    $data['thumbnail'] = $path;
                }
            } catch (\Exception $e) {
                $path = $file->store('uploads/transportasi', 'public');
                $data['thumbnail'] = $path;
            }
        }
        if ($request->filled('slug')) {
            $data['slug'] = $request->input('slug');
        }
        $transportasi->update($data);
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.transportasi.{$loc}");
            Cache::forget("home.featured.{$loc}");
        }
    return redirect()->route('panel.transportasi.index')->with('success', 'Transportasi updated');
    }

    public function transportasiDestroy(Transportasi $transportasi)
    {
        $transportasi->delete();
        foreach (config('app.locales', [app()->getLocale()]) as $loc) {
            Cache::forget("home.transportasi.{$loc}");
            Cache::forget("home.featured.{$loc}");
        }
    return redirect()->route('panel.transportasi.index')->with('success', 'Transportasi deleted');
    }
}
