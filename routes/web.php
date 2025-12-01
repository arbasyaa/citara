<?php

use App\Http\Controllers\Admin\WilayahController;
use App\Http\Controllers\Admin\DestinasiController as AdminDestinasiController;
use App\Http\Controllers\Admin\FotoDestinasiController;
use App\Http\Controllers\Admin\AkomodasiController;
use App\Http\Controllers\Admin\TransportasiController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\DestinasiController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLocale;

// Provide a named `login` route so middleware that redirects to route('login') works.
Route::get('/login', function () {
    return redirect()->route('panel.login');
})->name('login');

// Public Routes (apply locale middleware + rate limiting to prevent abuse)
Route::middleware([SetLocale::class, 'throttle:100,1'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/destinasi', [DestinasiController::class, 'index'])->name('destinasi.index');
    Route::get('/destinasi/{destinasi:slug}', [DestinasiController::class, 'show'])->name('destinasi.show');
    Route::get('/wilayah/{wilayah:slug}', [DestinasiController::class, 'byWilayah'])->name('wilayah.show');
    // Public Akomodasi & Transportasi pages (lightweight)
    Route::get('/akomodasi', [\App\Http\Controllers\Public\AkomodasiController::class, 'index'])->name('akomodasi.index');
    Route::get('/akomodasi/{akomodasi:slug}', [\App\Http\Controllers\Public\AkomodasiController::class, 'show'])->name('akomodasi.show');
    Route::get('/transportasi', [\App\Http\Controllers\Public\TransportasiController::class, 'index'])->name('transportasi.index');
    Route::get('/transportasi/{transportasi:slug}', [\App\Http\Controllers\Public\TransportasiController::class, 'show'])->name('transportasi.show');
    // Event Calendar
    Route::get('/kalender-kegiatan', [\App\Http\Controllers\Public\EventController::class, 'calendar'])->name('events.calendar');
});

// Language switch route
Route::get('/lang/{locale}', function ($locale) {
    $available = ['en', 'id'];
    if (! in_array($locale, $available)) {
        abort(404);
    }
    session(['locale' => $locale]);
    
    // Force session to save immediately
    session()->save();
    
    return redirect()->back();
})->name('lang.switch');

// Accessibility: Reduced motion toggle (session-based)
Route::get('/a11y/motion/{pref}', function (string $pref) {
    $pref = strtolower($pref);
    if (!in_array($pref, ['reduce', 'auto'])) {
        abort(400);
    }
    session(['reduced_motion' => $pref === 'reduce']);
    session()->save();
    return redirect()->back();
})->name('a11y.motion');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('wilayah', WilayahController::class);
    Route::resource('destinasi', AdminDestinasiController::class);
    Route::resource('foto-destinasi', FotoDestinasiController::class);
    Route::resource('akomodasi', AkomodasiController::class);
    Route::resource('transportasi', TransportasiController::class);
});

// Lightweight session-based admin panel (separate from existing auth admin)
Route::get('/panel/login', [AdminController::class, 'loginForm'])->name('panel.login');
Route::post('/panel/login', [AdminController::class, 'login'])
    ->middleware('throttle:5,1') // 5 attempts per minute
    ->name('panel.login.post');
Route::post('/panel/logout', [AdminController::class, 'logout'])->name('panel.logout');

Route::prefix('panel')->name('panel.')->middleware('throttle:60,1')->group(function () {
    // Protected routes using AdminAuth middleware
    Route::middleware([\App\Http\Middleware\AdminAuth::class, 'log.admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // Services panel removed (managed by standard /admin area). If you want to re-enable,
        // re-add routes and controller methods under panel.

        // Events
    Route::get('/events', [AdminController::class, 'eventsIndex'])->name('events.index');
    Route::get('/events/create', [AdminController::class, 'eventsCreate'])->name('events.create');
    Route::post('/events', [AdminController::class, 'eventsStore'])->name('events.store');
    Route::get('/events/{event}/edit', [AdminController::class, 'eventsEdit'])->name('events.edit');
    Route::put('/events/{event}', [AdminController::class, 'eventsUpdate'])->name('events.update');
    Route::delete('/events/{event}', [AdminController::class, 'eventsDestroy'])->name('events.destroy');
    // Destinasi search for admin combobox
    Route::get('/destinasi/search', [AdminController::class, 'destinasiSearch'])->name('destinasi.search');

    // Wilayah (panel)
    Route::get('/wilayah', [AdminController::class, 'wilayahIndex'])->name('wilayah.index');
    Route::get('/wilayah/create', [AdminController::class, 'wilayahCreate'])->name('wilayah.create');
    Route::post('/wilayah', [AdminController::class, 'wilayahStore'])->name('wilayah.store');
    Route::get('/wilayah/{wilayah}/edit', [AdminController::class, 'wilayahEdit'])->name('wilayah.edit');
    Route::put('/wilayah/{wilayah}', [AdminController::class, 'wilayahUpdate'])->name('wilayah.update');
    Route::delete('/wilayah/{wilayah}', [AdminController::class, 'wilayahDestroy'])->name('wilayah.destroy');

    // Destinasi (panel)
    Route::get('/destinasi', [AdminController::class, 'destinasiIndex'])->name('destinasi.index');
    Route::get('/destinasi/create', [AdminController::class, 'destinasiCreate'])->name('destinasi.create');
    Route::post('/destinasi', [AdminController::class, 'destinasiStore'])->name('destinasi.store');
    Route::get('/destinasi/{destinasi}/edit', [AdminController::class, 'destinasiEdit'])->name('destinasi.edit');
    Route::put('/destinasi/{destinasi}', [AdminController::class, 'destinasiUpdate'])->name('destinasi.update');
    Route::delete('/destinasi/{destinasi}', [AdminController::class, 'destinasiDestroy'])->name('destinasi.destroy');
    // Delete a photo from a destinasi via panel
    Route::delete('/destinasi/{destinasi}/foto/{foto}', [AdminController::class, 'destinasiPhotoDestroy'])->name('destinasi.photo.destroy');

    // Akomodasi (panel)
    Route::get('/akomodasi', [AdminController::class, 'akomodasiIndex'])->name('akomodasi.index');
    Route::get('/akomodasi/create', [AdminController::class, 'akomodasiCreate'])->name('akomodasi.create');
    Route::post('/akomodasi', [AdminController::class, 'akomodasiStore'])->name('akomodasi.store');
    Route::get('/akomodasi/{akomodasi}/edit', [AdminController::class, 'akomodasiEdit'])->name('akomodasi.edit');
    Route::put('/akomodasi/{akomodasi}', [AdminController::class, 'akomodasiUpdate'])->name('akomodasi.update');
    Route::delete('/akomodasi/{akomodasi}', [AdminController::class, 'akomodasiDestroy'])->name('akomodasi.destroy');

    // Transportasi (panel)
    Route::get('/transportasi', [AdminController::class, 'transportasiIndex'])->name('transportasi.index');
    Route::get('/transportasi/create', [AdminController::class, 'transportasiCreate'])->name('transportasi.create');
    Route::post('/transportasi', [AdminController::class, 'transportasiStore'])->name('transportasi.store');
    Route::get('/transportasi/{transportasi}/edit', [AdminController::class, 'transportasiEdit'])->name('transportasi.edit');
    Route::put('/transportasi/{transportasi}', [AdminController::class, 'transportasiUpdate'])->name('transportasi.update');
    Route::delete('/transportasi/{transportasi}', [AdminController::class, 'transportasiDestroy'])->name('transportasi.destroy');
    });
});

// Health check endpoint for monitoring (no auth required for uptime checks)
Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        $dbStatus = 'connected';
    } catch (\Exception $e) {
        $dbStatus = 'disconnected';
    }

    Cache::put('health_check', true, 60);
    $cacheStatus = Cache::has('health_check') ? 'working' : 'failing';

    $status = ($dbStatus === 'connected' && $cacheStatus === 'working') ? 'healthy' : 'unhealthy';

    return response()->json([
        'status' => $status,
        'database' => $dbStatus,
        'cache' => $cacheStatus,
        'timestamp' => now()->toIso8601String(),
        'app' => [
            'name' => config('app.name'),
            'env' => app()->environment(),
        ],
    ], $status === 'healthy' ? 200 : 503);
})->name('health');
