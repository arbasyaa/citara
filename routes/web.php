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

// Public Routes (apply locale middleware to set app locale from session)
Route::middleware([SetLocale::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/destinasi', [DestinasiController::class, 'index'])->name('destinasi.index');
    Route::get('/destinasi/{destinasi:slug}', [DestinasiController::class, 'show'])->name('destinasi.show');
    Route::get('/wilayah/{wilayah:slug}', [DestinasiController::class, 'byWilayah'])->name('wilayah.show');
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
Route::post('/panel/login', [AdminController::class, 'login'])->name('panel.login.post');
Route::post('/panel/logout', [AdminController::class, 'logout'])->name('panel.logout');

Route::prefix('panel')->name('panel.')->group(function () {
    // Protected routes using AdminAuth middleware
    Route::middleware([\App\Http\Middleware\AdminAuth::class])->group(function () {
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
