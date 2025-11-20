# Cilacap Tourism and Creative - Website Pariwisata

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![Vite](https://img.shields.io/badge/Vite-7.x-yellow)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-cyan)

Website pariwisata Cilacap yang menampilkan destinasi wisata & kuliner, akomodasi, transportasi, layanan, dan kalender event.

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Requirements](#-requirements)
- [Quick Start](#-quick-start)
- [Instalasi Manual](#-instalasi-manual)
- [Struktur Database](#-struktur-database)
- [Admin Panel](#-admin-panel)
- [Development Workflow](#-development-workflow)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Dokumentasi Tambahan](#-dokumentasi-tambahan)
- [Kontribusi](#-kontribusi)

---

## 🎯 Tentang Proyek

**Cilacap Tourism and Creative** adalah website pariwisata yang dibangun untuk mempromosikan destinasi wisata dan kuliner, akomodasi, transportasi, serta berbagai event di Kabupaten Cilacap.

### Fitur Unggulan

1. **Digitalisasi Pariwisata**: Portal informasi terpadu untuk destinasi wisata Cilacap
2. **Kategorisasi Lengkap**: Pemisahan destinasi wisata dan kuliner yang jelas
3. **Informasi Terpusat**: Destinasi, akomodasi, transportasi, layanan, dan event dalam satu platform
4. **Dual Admin Panel**: Dua sistem admin yang terpisah untuk fleksibilitas pengelolaan
5. **Performa Optimal**: Dioptimasi untuk kecepatan loading dan SEO

---

## ✨ Fitur Utama

### Fitur Publik (Website)

#### 1. **Destinasi Wisata & Kuliner** 🏖️🍜
- **Kategori Ganda**: Pemisahan destinasi wisata dan kuliner dengan field `tipe`
- Daftar lengkap destinasi di seluruh Cilacap
- Pengelompokan berdasarkan wilayah
- Galeri foto untuk setiap destinasi (slider utama + gallery)
- Deskripsi lengkap dengan lokasi
- Integrasi Google Maps untuk navigasi
- Filter destinasi unggulan & populer
- Sistem slug SEO-friendly untuk URL

#### 2. **Wilayah Wisata** 🗺️
- Pengelompokan destinasi berdasarkan wilayah
- Deskripsi setiap wilayah dengan gambar
- Counter otomatis jumlah destinasi per wilayah
- Halaman detail untuk setiap wilayah
- Responsive card design dengan gradient overlay

#### 3. **Akomodasi** 🏨
- Daftar lengkap hotel, wisma, villa, homestay
- Informasi lokasi dan kontak
- Link website untuk booking
- Deskripsi fasilitas lengkap
- Hero image dengan gradient overlay
- Sticky sidebar dengan informasi penting

#### 4. **Transportasi** 🚌
- Informasi transportasi lokal
- Rute perjalanan detail
- Kategori: Kereta Api, Bus, Pesawat, Transportasi Lokal
- Hero design konsisten dengan destinasi
- Info tipe dan rute di sidebar

#### 5. **Layanan Wisata** 🎯
- Informasi layanan tambahan (tour guide, paket wisata, dll)
- Deskripsi lengkap layanan
- Gambar dan informasi kontak
- Grid layout responsif

#### 6. **Kalender Event** 📅
- Kalender kegiatan wisata tahunan (2026+)
- Tampilan kartu per bulan dengan gradient headers
- Mode single-month untuk detail event
- Event cards dengan border hover effects
- Informasi tanggal, lokasi, dan deskripsi
- Kategori event: Festival, Workshop, Pameran
- Info section dengan gradient cards

#### 7. **Homepage Dinamis** 🏠
- Hero section dengan animated pattern
- Featured destinations showcase
- Wilayah wisata grid (hanya menampilkan wilayah dengan destinasi)
- Services preview
- Calendar events highlight
- Smooth scroll animations

#### 8. **Responsive Design** 📱
- Tampilan optimal di desktop, tablet, mobile
- Fixed navbar dengan blur effect
- Touch-friendly navigation
- Optimized images dengan lazy loading
- Mobile-first approach

---

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 12** - PHP Framework terbaru dengan fitur modern
- **PHP 8.2+** - Bahasa pemrograman dengan performa tinggi
- **MySQL** - Database relational untuk production
- **SQLite** - Database untuk testing (optional)

### Frontend
- **Vite** - Modern build tool untuk asset bundling
- **TailwindCSS 3.x** - Utility-first CSS framework
- **Alpine.js** (via Livewire) - JavaScript framework lightweight
- **Blade Templates** - Laravel templating engine

### Development Tools
- **Composer** - PHP dependency manager
- **NPM** - Node package manager
- **Git** - Version control system
- **Laravel Pint** - PHP code styling tool

### Additional Libraries
- **Livewire** - Full-stack framework untuk Laravel
- **Intervention Image** - Image manipulation library
- **Laravel Sanctum** - API authentication

---

## 📦 Requirements

### Minimum Requirements
- **PHP**: >= 8.2
- **Composer**: Latest version
- **Node.js**: >= 18.x
- **NPM**: >= 9.x
- **MySQL**: >= 8.0 atau MariaDB >= 10.3
- **Web Server**: Apache atau Nginx

### PHP Extensions (Required)
```
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- PDO_MySQL
- Tokenizer
- XML
```

### Recommended
- **Redis** - Untuk caching dan queue (optional)
- **Supervisor** - Untuk queue worker management
- **SSL Certificate** - Untuk HTTPS di production

---

## 🚀 Quick Start

Untuk setup dan development yang cepat, gunakan composer scripts:

### Setup Awal (Pertama Kali)
```bash
# Clone repository
git clone https://github.com/arbasyaa/citara.git
cd citara-dev

# Setup otomatis: install dependencies, migrate, build assets
composer run-script setup
```

### Development Mode
```bash
# Jalankan server, queue, pail, dan vite secara bersamaan
composer run-script dev
```

Website akan berjalan di: `http://localhost:8000`

---

## 🔧 Instalasi Manual

### 1. Clone Repository
```bash
git clone https://github.com/arbasyaa/citara.git
cd citara-dev
```

### 2. Install Dependencies
```bash
# PHP dependencies
composer install

# Node dependencies
npm install
```

### 3. Setup Environment
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit `.env` file:
```env
APP_NAME="Cilacap Tourism and Creative"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database (MySQL Production)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citara_db
DB_USERNAME=root
DB_PASSWORD=

# Locale
APP_LOCALE=id
APP_FALLBACK_LOCALE=id

# Admin Panel Password (untuk /panel)
PANEL_PASSWORD=your_secure_password
```

### 5. Database Setup
```bash
# Run migrations
php artisan migrate

# (Optional) Seed dengan data contoh
php artisan db:seed

# Backfill tipe destinasi jika upgrade dari versi lama
php artisan db:seed --class=BackfillDestinasiTipeSeeder
```

### 6. Storage Link
```bash
php artisan storage:link
```

### 7. Build Assets
```bash
# Development (watch mode)
npm run dev

# Production (minified)
npm run build
```

### 8. Run Application
```bash
# Simple artisan serve
php artisan serve

# Atau gunakan composer script untuk dev lengkap
composer run-script dev
```

---

## 🗄️ Struktur Database

### Tabel Utama

#### 1. **wilayah**
```sql
- id (bigint, PK)
- nama (varchar 255)
- slug (varchar 255, unique)
- deskripsi (text, nullable)
- gambar (varchar 255, nullable)
- timestamps
```

#### 2. **destinasi** ⭐ Updated
```sql
- id (bigint, PK)
- id_wilayah (bigint, FK → wilayah)
- nama (varchar 255)
- slug (varchar 255, unique)
- tipe (varchar 255, default 'wisata') -- 'wisata' atau 'kuliner'
- deskripsi (text, nullable)
- alamat_lokasi (text, nullable)
- url_gmaps (text, nullable)
- is_popular (boolean, default 0)
- is_featured (boolean, default 0)
- timestamps
```
**Note**: Field `tipe` ditambahkan untuk membedakan destinasi wisata dan kuliner.

#### 3. **foto_destinasi**
```sql
- id (bigint, PK)
- id_destinasi (bigint, FK → destinasi, onDelete: cascade)
- url (varchar 255)
- keterangan (text, nullable)
- apakah_slider_utama (boolean, default 0)
- timestamps
```

#### 4. **akomodasi**
```sql
- id (bigint, PK)
- nama (varchar 255)
- slug (varchar 255, unique)
- tipe (varchar 255, nullable) -- Hotel, Wisma, Villa, Homestay
- lokasi (text, nullable)
- deskripsi (text, nullable)
- nomor_telepon (varchar 50, nullable)
- url_situs_web (text, nullable)
- gambar (varchar 255, nullable)
- timestamps
```

#### 5. **transportasi**
```sql
- id (bigint, PK)
- nama (varchar 255)
- slug (varchar 255, unique)
- tipe (varchar 255, nullable) -- Kereta Api, Bus, Pesawat, dll
- rute (text, nullable)
- deskripsi (text, nullable)
- gambar (varchar 255, nullable)
- timestamps
```

#### 6. **services**
```sql
- id (bigint, PK)
- nama (varchar 255)
- slug (varchar 255, unique)
- deskripsi (text, nullable)
- image (varchar 255, nullable)
- timestamps
```

#### 7. **calendar_events**
```sql
- id (bigint, PK)
- title (varchar 255)
- description (text, nullable)
- location (varchar 255, nullable)
- event_date (date)
- image (varchar 255, nullable)
- timestamps
```

#### 8. **users** (Admin Auth)
```sql
- id (bigint, PK)
- name (varchar 255)
- email (varchar 255, unique)
- email_verified_at (timestamp, nullable)
- password (varchar 255)
- remember_token (varchar 100, nullable)
- timestamps
```

### Relasi Database
```
wilayah (1) ──< (N) destinasi
destinasi (1) ──< (N) foto_destinasi
```

### Konvensi Penamaan
- **Table names**: Singular (contoh: `wilayah`, `destinasi`, bukan `wilayahs`/`destinasis`)
- **Slug generation**: Otomatis dibuat di model `booted()` method
- **Foreign keys**: Menggunakan `onDelete('cascade')` untuk integritas referensial

---

## 👨‍💼 Admin Panel

### Sistem Dual Admin

Proyek ini memiliki **DUA sistem admin** yang terpisah:

#### 1. **Panel (Lightweight Admin)** - `/panel`
```
URL: http://localhost:8000/panel
Auth: Password-based (dari .env)
Middleware: AdminAuth
Target: Admin konten yang tidak perlu full auth system
```

**Setup:**
```env
# .env
PANEL_PASSWORD=your_secure_password_here
```

**Cara Akses:**
1. Buka `/panel`
2. Masukkan password dari `.env` → `PANEL_PASSWORD`
3. Password tersimpan di session

**Fitur:**
- ✅ CRUD Destinasi (dengan kategori wisata/kuliner)
- ✅ CRUD Wilayah
- ✅ CRUD Akomodasi
- ✅ CRUD Transportasi
- ✅ CRUD Services
- ✅ CRUD Calendar Events
- ✅ Upload & manage images
- ✅ Simple interface

#### 2. **Admin (Full Auth)** - `/admin`
```
URL: http://localhost:8000/admin
Auth: Laravel Authentication (users table)
Middleware: auth
Target: Super admin dengan role-based access
```

**Setup User:**
```bash
php artisan tinker
```

```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('your_password')
]);
```

**Fitur:**
- ✅ Full CRUD dengan advanced features
- ✅ Role-based access control (future)
- ✅ Activity logging (future)
- ✅ Bulk operations

### CRUD Operations

#### Destinasi Management (`/panel/destinasi`)

**Fields:**
- `nama` (required) - Nama destinasi
- `id_wilayah` (optional) - Relasi ke wilayah
- `tipe` (required, default: 'wisata') - 'wisata' atau 'kuliner' ⭐
- `deskripsi` (optional) - Deskripsi lengkap
- `alamat_lokasi` (optional) - Alamat detail
- `url_gmaps` (optional) - Link Google Maps
- `is_popular` (boolean) - Tandai sebagai populer
- `is_featured` (boolean) - Tampilkan di featured
- `image` - Upload gambar utama

**Features:**
- Auto slug generation dari nama
- Multiple photo upload (via `foto_destinasi`)
- Set slider utama
- Filter by wilayah
- Filter by tipe (wisata/kuliner)

#### Wilayah Management (`/panel/wilayah`)

**Fields:**
- `nama` (required)
- `deskripsi` (optional)
- `gambar` (optional)

**Features:**
- Auto slug generation
- Counter destinasi per wilayah
- Cascade delete protection

#### Akomodasi, Transportasi, Services, Calendar Events

Semua menggunakan pola CRUD yang sama dengan:
- Auto slug generation
- Image upload
- Soft deletes (optional)
- Search & filter

### Implementasi Detail

#### 1. **Route Language Switcher**

File: `routes/web.php`
```php
Route::get('/lang/{locale}', function ($locale) {
    // Validasi hanya 'en' atau 'id'
    $available = ['en', 'id'];
    if (!in_array($locale, $available)) {
        abort(404);
    }
    
    // Simpan pilihan bahasa di session
    session(['locale' => $locale]);
    session()->save();
    
    // Redirect kembali ke halaman sebelumnya
    return redirect()->back();
})->name('lang.switch');
```

**Cara Kerja:**
1. User klik tombol EN atau ID
2. Route `/lang/en` atau `/lang/id` dipanggil
3. Locale disimpan di session: `session(['locale' => 'en'])`
4. User dikembalikan ke halaman yang sama
5. Halaman reload dengan bahasa baru

#### 2. **Middleware SetLocale**

File: `app/Http/Middleware/SetLocale.php`
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Ambil locale dari session, default 'id'
        $locale = session('locale', 'id');
        
        // Validasi locale
        $availableLocales = ['en', 'id'];
        if (!in_array($locale, $availableLocales)) {
            $locale = 'id';
        }
        
        // Set locale aplikasi Laravel
        App::setLocale($locale);
        
        return $next($request);
    }
}
```

**Cara Kerja:**
1. Middleware dijalankan **sebelum** controller di setiap request
2. Membaca locale dari session (default: 'id' jika belum ada)
3. Validasi locale (hanya 'en' atau 'id')
4. Set locale Laravel: `App::setLocale($locale)`
5. Sekarang `app()->getLocale()` akan return 'en' atau 'id' di seluruh aplikasi

#### 3. **Registrasi Middleware**

File: `routes/web.php`
```php
use App\Http\Middleware\SetLocale;

// Terapkan middleware ke semua route publik
Route::middleware([SetLocale::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/destinasi', [DestinasiController::class, 'index']);
    Route::get('/destinasi/{destinasi:slug}', [DestinasiController::class, 'show']);
    Route::get('/wilayah/{wilayah:slug}', [DestinasiController::class, 'byWilayah']);
});
```

#### 4. **Model Helper Method (Inti Fallback)**

File: `app/Models/Destinasi.php`
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destinasi extends Model
{
    protected $table = 'destinasi';
    
    protected $fillable = [
        'id_wilayah',
        'nama',
        'slug',
        'deskripsi',
        'deskripsi_en',  // Kolom bahasa Inggris
        'alamat_lokasi',
        'url_gmaps',
        'is_popular',
        'is_featured',
    ];

    /**
     * Mendapatkan deskripsi sesuai bahasa yang dipilih
     * 
     * MECHANISM FALLBACK:
     * - Jika locale = 'en' DAN deskripsi_en tersedia → return deskripsi_en
     * - Jika locale = 'id' ATAU deskripsi_en kosong → return deskripsi (Indonesia)
     */
    public function getTranslatedDescription(): string
    {
        // Cek apakah bahasa saat ini English DAN teks English ada
        if (app()->getLocale() === 'en' && !empty($this->deskripsi_en)) {
            return $this->deskripsi_en;  // Return English
        }
        
        // Fallback: return bahasa Indonesia
        // Ini akan dijalankan jika:
        // 1. Locale adalah 'id', ATAU
        // 2. Locale adalah 'en' TAPI deskripsi_en kosong/NULL
        return $this->deskripsi ?? '';  // Return Indonesia atau string kosong
    }
    
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }
    
    public function foto()
    {
        return $this->hasMany(FotoDestinasi::class, 'id_destinasi');
    }
}
```

**Tabel Kebenaran (Truth Table):**

| Locale | deskripsi_en ada? | Return        | Alasan                              |
|--------|------------------|---------------|-------------------------------------|
| 'id'   | YES              | deskripsi     | User pilih Indonesia                |
| 'id'   | NO               | deskripsi     | User pilih Indonesia                |
| 'en'   | YES              | deskripsi_en  | English tersedia & dipilih          |
| 'en'   | NO               | deskripsi     | **FALLBACK** - English tidak ada    |

**Model lain yang sama:**
- `app/Models/Wilayah.php` → `getTranslatedDescription()`
- `app/Models/Transportasi.php` → `getTranslatedDescription()`
- `app/Models/Akomodasi.php` → `getTranslatedDescription()`

#### 5. **Penggunaan di View**

File: `resources/views/public/destinasi/show.blade.php`

**❌ SALAH (Tidak bilingual):**
```blade
<p>{{ $destinasi->deskripsi }}</p>
<!-- Selalu tampil Indonesia, tidak peduli bahasa yang dipilih -->
```

**✅ BENAR (Bilingual dengan fallback):**
```blade
<p>{{ $destinasi->getTranslatedDescription() }}</p>
<!-- Otomatis sesuai bahasa, fallback ke Indonesia jika perlu -->
```

**Contoh lengkap:**
```blade
<div class="bg-white rounded-lg shadow-lg p-6">
    <!-- Heading menggunakan translation file -->
    <h2 class="text-2xl font-bold mb-4">
        {{ __('site.about_destination') }}
    </h2>
    
    <!-- Konten menggunakan helper method -->
    <div class="prose max-w-none">
        {{ $destinasi->getTranslatedDescription() }}
    </div>
</div>

<!-- Deskripsi terpotong dengan limit -->
<p class="text-gray-600">
    {{ Str::limit($destinasi->getTranslatedDescription(), 150) }}
</p>
```

#### 6. **Translation Files untuk UI Statis**

File: `resources/lang/en/site.php`
```php
<?php

return [
    'site_name' => 'Cilacap Tourism and Creative',
    'home' => 'Home',
    'destinations' => 'Destinations',
    'accommodation' => 'Accommodation',
    'transport' => 'Transportation',
    'about_destination' => 'About Destination',
    'photo_gallery' => 'Photo Gallery',
    'location' => 'Location',
    'open_gmaps' => 'Open in Google Maps',
    // ... dll
];
```

File: `resources/lang/id/site.php`
```php
<?php

return [
    'site_name' => 'Cilacap Tourism and Creative',
    'home' => 'Beranda',
    'destinations' => 'Destinasi',
    'accommodation' => 'Akomodasi',
    'transport' => 'Transportasi',
    'about_destination' => 'Tentang Destinasi',
    'photo_gallery' => 'Galeri Foto',
    'location' => 'Lokasi',
    'open_gmaps' => 'Buka di Google Maps',
    // ... dll
];
```

**Cara Penggunaan:**
```blade
<!-- Navigation -->
<a href="{{ route('home') }}">{{ __('site.home') }}</a>
<a href="{{ route('destinasi.index') }}">{{ __('site.destinations') }}</a>

<!-- Headings -->
<h1>{{ __('site.hero_title') }}</h1>
<h2>{{ __('site.about_destination') }}</h2>

<!-- Buttons -->
<button>{{ __('site.search_button') }}</button>

<!-- Kombinasi dengan data dinamis -->
<h2>{{ __('site.destinations_in') }} {{ $wilayah->nama }}</h2>
```

**Cara Kerja `__()`:**
1. Laravel baca locale saat ini: `app()->getLocale()`
2. Jika 'en', baca `resources/lang/en/site.php`
3. Jika 'id', baca `resources/lang/id/site.php`
4. Return string terjemahan untuk key tersebut

#### 7. **UI Language Switcher**

File: `resources/views/layouts/public.blade.php`
```blade
<!-- Language switcher di navbar -->
<div class="flex items-center space-x-1 ml-2 border-l border-white/30 pl-3">
    <a href="{{ route('lang.switch', 'en') }}" 
       class="text-white font-medium px-2 py-1 rounded transition 
              {{ app()->getLocale() === 'en' ? 'bg-white/20' : 'hover:bg-white/10' }}">
        EN
    </a>
    <span class="text-white/50">|</span>
    <a href="{{ route('lang.switch', 'id') }}" 
       class="text-white font-medium px-2 py-1 rounded transition 
              {{ app()->getLocale() === 'id' ? 'bg-white/20' : 'hover:bg-white/10' }}">
        ID
    </a>
</div>
```

**Fitur:**
- Selalu terlihat (tidak menggunakan dropdown hover yang sulit)
- Bahasa aktif di-highlight dengan background
- Click langsung switch bahasa
- Kembali ke halaman yang sama setelah switch

### Contoh Skenario Lengkap

#### Skenario 1: User Indonesia (Default)

**Data di database:**
```
nama: "Pantai Teluk Penyu"
deskripsi: "Pantai indah dengan pemandangan sunset yang menakjubkan"
deskripsi_en: "Beautiful beach with stunning sunset views"
```

**Perjalanan User:**
1. User buka website (pertama kali)
2. Middleware: `session('locale')` return `NULL` → default ke 'id'
3. `App::setLocale('id')` dipanggil
4. User klik destinasi "Pantai Teluk Penyu"
5. View render: `{{ $destinasi->getTranslatedDescription() }}`
6. Method eksekusi:
   - `app()->getLocale() === 'en'`? **FALSE** (locale adalah 'id')
   - Skip kondisi pertama
   - Return: `$this->deskripsi`
7. User lihat: **"Pantai indah dengan pemandangan sunset yang menakjubkan"**

#### Skenario 2: User Switch ke English

**User sama, data sama**

**Perjalanan:**
1. User klik tombol **"EN"** di navbar
2. Route `/lang/en` dipanggil:
   - `session(['locale' => 'en'])` → simpan 'en' di session
   - `session()->save()` → force save
   - `redirect()->back()` → kembali ke halaman
3. Halaman reload
4. Middleware:
   - `session('locale')` return 'en'
   - `App::setLocale('en')` dipanggil
5. View render lagi: `{{ $destinasi->getTranslatedDescription() }}`
6. Method eksekusi:
   - `app()->getLocale() === 'en'`? **TRUE**
   - `!empty($this->deskripsi_en)`? **TRUE** (ada teks English)
   - Return: `$this->deskripsi_en`
7. User lihat: **"Beautiful beach with stunning sunset views"**
8. UI juga berubah:
   - Navigation: "Home" bukan "Beranda"
   - Button: "Search" bukan "Cari"
   - Heading: "About Destination" bukan "Tentang Destinasi"

#### Skenario 3: User English, Tidak Ada Terjemahan (Fallback)

**Data di database:**
```
nama: "Benteng Pendem"
deskripsi: "Benteng bersejarah dari era kolonial Belanda"
deskripsi_en: NULL  ← Tidak ada terjemahan English
```

**Perjalanan:**
1. User sudah pilih "EN" (session berisi 'en')
2. Middleware: `App::setLocale('en')`
3. User klik "Benteng Pendem"
4. View render: `{{ $destinasi->getTranslatedDescription() }}`
5. Method eksekusi:
   - `app()->getLocale() === 'en'`? **TRUE**
   - `!empty($this->deskripsi_en)`? **FALSE** (NULL!)
   - Kondisi pertama **GAGAL** (harus KEDUA TRUE)
   - Lanjut ke return kedua
   - Return: `$this->deskripsi`
6. User lihat: **"Benteng bersejarah dari era kolonial Belanda"**
7. UI tetap English:
   - Heading: "About Destination" (dari translation file)
   - Button: "Search" (dari translation file)
   - Hanya konten deskripsi yang Indonesia (fallback)

**Benefit Fallback:**
- User tetap dapat informasi (lebih baik Indonesia daripada kosong)
- Website tetap fungsional
- Tidak ada error atau halaman blank
- Admin bisa tambahkan terjemahan nanti tanpa breaking

### Keunggulan Arsitektur Ini

1. **Graceful Degradation**: Website tidak pernah tampil blank, selalu ada konten
2. **Optional Translation**: Admin bisa terjemahkan bertahap, website tetap jalan
3. **SEO Friendly**: Kedua bahasa ter-index search engine
4. **Simple Maintenance**: Hanya dua kolom per field, tidak kompleks
5. **Performance**: Tidak ada extra query, hanya pemilihan kolom
6. **Scalable**: Mudah tambah bahasa lain (tinggal tambah `deskripsi_fr`, dll)
7. **User Friendly**: Switch bahasa smooth tanpa kehilangan konteks
8. **Developer Friendly**: Code clean, mudah di-maintain

---

## 👨‍💼 Fitur Admin Panel

### Akses Admin

Proyek ini memiliki **DUA sistem admin**:

#### 1. **Panel (Lightweight Admin)** - `/panel`
- **URL**: `http://localhost:8000/panel`
- **Authentication**: Password-based dari `.env`
- **Konfigurasi**: 
  ```env
  PANEL_PASSWORD=your_password_here
  ```
- **Fitur**: CRUD dasar untuk semua entitas
- **Target**: Admin konten yang tidak perlu full auth

#### 2. **Admin (Full Auth)** - `/admin`
- **URL**: `http://localhost:8000/admin`
- **Authentication**: Laravel Auth (email + password)
- **Middleware**: `auth` middleware
- **Fitur**: Advanced management dengan role-based access
- **Target**: Super admin dengan akun terdaftar

---

## 🔨 Development Workflow

### Composer Scripts (Recommended)

Proyek ini menyediakan helper scripts untuk memudahkan development:

#### Setup Awal
```bash
composer run-script setup
```
Menjalankan: env copy, key generate, storage link, migrate, npm install, npm build

#### Development Mode
```bash
composer run-script dev
```
Menjalankan secara paralel:
- `php artisan serve` - Laravel server (port 8000)
- `php artisan queue:listen` - Queue worker
- `php artisan pail` - Real-time log viewer
- `npm run dev` - Vite dev server (hot reload)

#### Testing
```bash
composer test
# atau
php artisan test
```

#### Clear Caches
```bash
# Clear semua cache (view, config, route, application)
php artisan optimize:clear

# Clear individual caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Common Development Tasks

#### Menambah Model Baru dengan Slug

Contoh: Model baru `Event` dengan auto-slug

```php
// app/Models/Event.php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $table = 'events'; // singular table name
    
    protected $fillable = ['nama', 'slug', 'deskripsi'];
    
    protected static function booted()
    {
        static::creating(function ($event) {
            $slug = Str::slug($event->nama);
            $count = 1;
            
            while (static::where('slug', $slug)->exists()) {
                $slug = Str::slug($event->nama) . '-' . $count++;
            }
            
            $event->slug = $slug;
        });
    }
}
```

#### Menambah Route Public

```php
// routes/web.php
use App\Http\Controllers\Public\EventController;

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');
```

#### Menambah Admin CRUD

```php
// routes/web.php - Panel routes
Route::middleware(['admin.auth'])->prefix('panel')->name('panel.')->group(function () {
    Route::resource('events', Admin\EventController::class);
});
```

### Debugging Tips

#### Missing Records di Homepage

Jika wilayah/destinasi tidak muncul di homepage:

**Penyebab**: `HomeController@index` filter wilayah dengan `withCount('destinasi')->having('destinasi_count', '>', 0)`

**Solusi**:
```bash
# Cek apakah wilayah punya destinasi
php artisan tinker
>>> Wilayah::withCount('destinasi')->get()
```

#### Slug Collision

Model sudah implement unique slug generation di `booted()` method. Lihat `app/Models/Wilayah.php` dan `app/Models/Destinasi.php` untuk contoh implementasi.

#### Image Not Showing

**Checklist**:
1. Storage link created? `php artisan storage:link`
2. File exists? Check `storage/app/public/uploads/`
3. Permissions? `chmod -R 775 storage bootstrap/cache`
4. Using `ImageUrl::url()` service for fallback

#### Cache Issues

Setelah ubah `.env` atau config, selalu clear cache:
```bash
php artisan config:clear
php artisan cache:clear
```

### Important Conventions

- **Table naming**: Singular (wilayah, destinasi, bukan wilayahs/destinasis)
- **Slug generation**: Otomatis di model `booted()` method
- **Image storage**: `storage/app/public/uploads/` dengan disk `public`
- **Defensive coding**: Controllers cek `Schema::hasTable()` sebelum query

❌ **Jangan Diterjemahkan:**
- Nama destinasi (tetap autentik: "Pantai Teluk Penyu")
- Nama wilayah (tetap original: "Cilacap Selatan")
- Alamat lokasi (untuk akurasi GPS)
- Nomor telepon, email

#### 2. **Tips Menulis Deskripsi**

**Bahasa Indonesia:**
- Natural dan mengalir
- Informasi lengkap dan jelas
- Sertakan keunikan destinasi
- Tambahkan tips praktis

**Bahasa Inggris:**
- Jangan terjemahan literal word-by-word
- Gunakan grammar yang benar
- Tambah konteks untuk orang asing
- Jelaskan istilah lokal jika perlu

**Contoh Bagus:**
```
Indonesia: "Dekat dengan pasar tradisional yang ramai"
English: "Near a bustling traditional market (fresh produce and local souvenirs)"
           ↑ Tambah penjelasan untuk turis asing
```

**Contoh Buruk:**
```
Indonesia: "Pantai indah dengan pemandangan sunset yang menakjubkan"
English: "Beach beautiful with view sunset that amazing"
          ↑ Grammar salah, terlalu literal
```

#### 3. **Mengelola Gambar**

**Format yang Direkomendasikan:**
- Format: JPG atau PNG
- Ukuran: Max 4MB
- Resolusi: Minimal 1200x800px untuk kualitas bagus
- Aspect Ratio: 3:2 atau 16:9 untuk tampilan optimal

**Tips Upload:**
- Upload foto berkualitas tinggi untuk slider utama
- Gunakan foto landscape untuk hero image
- Centang "Slider Utama" untuk foto cover destinasi
- Upload beberapa foto untuk galeri

---

## 🧪 Testing

### Manual Testing

#### Test Bahasa

**Test 1: Default Bahasa**
```
1. Buka website di browser baru (incognito)
2. Expected: Website tampil dalam Bahasa Indonesia
3. Check: Navigasi, tombol, konten semua Indonesia
```

**Test 2: Switch ke English**
```
1. Klik tombol "EN"
2. Expected: Semua UI berubah ke English
3. Check: 
   - Navigation: "Home" bukan "Beranda"
   - Buttons: "Search" bukan "Cari"
   - Konten: Deskripsi English (jika ada)
```

**Test 3: Fallback Mechanism**
```
1. Set bahasa ke English
2. Buka destinasi tanpa terjemahan English
3. Expected: Tampil deskripsi Indonesia (fallback)
4. Check: Tidak ada error, tidak blank
```

**Test 4: Persistence**
```
1. Pilih English
2. Navigate ke halaman lain
3. Expected: Bahasa tetap English
4. Refresh browser
5. Expected: Masih English (session aktif)
```

#### Test CRUD Admin

**Test 5: Create Destinasi**
```
1. Login ke /panel
2. Tambah destinasi baru dengan kedua deskripsi
3. Expected: Data tersimpan di database
4. Check: Muncul di website publik
```

**Test 6: Edit Terjemahan**
```
1. Edit destinasi yang belum ada terjemahan
2. Tambahkan deskripsi English
3. Save
4. Check: Terjemahan muncul saat switch ke EN
```

**Test 7: Upload Gambar**
```
1. Create/Edit destinasi
2. Upload gambar (max 4MB)
3. Expected: Gambar tersimpan di storage/app/public/uploads
4. Check: Gambar tampil di halaman detail
```

---

## 🧪 Testing

### Run Tests
```bash
# Via composer script
composer test

# Via artisan
php artisan test

# Specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# With coverage (requires xdebug)
php artisan test --coverage
```

### Writing Tests

Contoh test untuk Destinasi:

```php
// tests/Feature/DestinasiTest.php
public function test_can_view_destinasi_index()
{
    $response = $this->get('/destinasi');
    $response->assertStatus(200);
    $response->assertSee('Destinasi Wisata');
}

public function test_can_view_destinasi_by_tipe()
{
    $wisata = Destinasi::factory()->create(['tipe' => 'wisata']);
    $kuliner = Destinasi::factory()->create(['tipe' => 'kuliner']);
    
    $response = $this->get('/destinasi?tipe=wisata');
    $response->assertSee($wisata->nama);
    $response->assertDontSee($kuliner->nama);
}
```

---

## 🚀 Deployment

### Quick Deploy Script

Gunakan script deploy yang sudah tersedia:

```bash
# Deploy dengan optimasi
bash deploy-optimize.sh
```

Script ini akan menjalankan:
- Git pull
- Composer install
- NPM install & build
- Database migration
- Cache optimization
- Permission fixes

### Manual Deployment

#### 1. **Environment Configuration**

Update `.env` untuk production:

```env
APP_NAME="Cilacap Tourism and Creative"
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database Production
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citara_production
DB_USERNAME=citara_user
DB_PASSWORD=strong_password_here

# Session (gunakan database di production)
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Cache (gunakan redis untuk performa optimal)
CACHE_DRIVER=file
QUEUE_CONNECTION=database

# Panel Password
PANEL_PASSWORD=your_secure_production_password
```

#### 2. **Optimize untuk Production**

```bash
# Install dependencies (no dev)
composer install --optimize-autoloader --no-dev

# Run migrations
php artisan migrate --force

# Build production assets
npm run build

# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
php artisan storage:link
```

#### 3. **Set Permissions**

```bash
# Set ownership (adjust user:group sesuai server)
sudo chown -R www-data:www-data /path/to/citara-dev

# Set directory permissions
sudo find /path/to/citara-dev -type d -exec chmod 755 {} \;

# Set file permissions
sudo find /path/to/citara-dev -type f -exec chmod 644 {} \;

# Set storage writable
sudo chmod -R 775 storage bootstrap/cache
```

#### 4. **Web Server Configuration**

**Nginx Example:**
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/citara-dev/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Performance Optimization

Lihat dokumentasi lengkap: `docs/PERFORMANCE_OPTIMIZATION.md`

**Quick tips:**
- Enable OPcache di production
- Gunakan Redis untuk cache dan queue
- Optimize images sebelum upload
- Enable gzip compression di web server
- Use CDN untuk static assets

---

## 📚 Dokumentasi Tambahan

Proyek ini memiliki dokumentasi lengkap untuk topik-topik khusus:

### 1. **LOCALIZATION.md** (`docs/LOCALIZATION.md`)
- Panduan lengkap sistem lokalisasi Laravel native
- Cara menambah translation keys
- Best practices untuk multilingual content
- Language switching mechanism

### 2. **PERFORMANCE_OPTIMIZATION.md** (`docs/PERFORMANCE_OPTIMIZATION.md`)
- Optimasi database query
- Caching strategies
- Image optimization
- Server configuration tips
- Load testing guidelines

### 3. **SINGLE_LANGUAGE_MIGRATION.md** (`docs/SINGLE_LANGUAGE_MIGRATION.md`)
- Panduan migrasi dari sistem bilingual ke single language
- Database cleanup procedures
- Code refactoring steps

### Copilot Instructions

File `.github/copilot-instructions.md` berisi panduan untuk AI coding agents yang bekerja dengan repository ini. Lihat file tersebut untuk:
- Konvensi kode proyek
- Lokasi file penting
- Common pitfalls
- Development workflows

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Berikut cara berkontribusi:

### 1. Fork & Clone
```bash
git clone https://github.com/YOUR_USERNAME/citara.git
cd citara-dev
```

### 2. Create Feature Branch
```bash
git checkout -b feature/new-feature
# atau
git checkout -b fix/bug-fix
```

### 3. Develop & Test
```bash
# Install dependencies
composer install
npm install

# Run tests
composer test

# Check code style
./vendor/bin/pint
```

### 4. Commit & Push
```bash
git add .
git commit -m "feat: add new feature"
git push origin feature/new-feature
```

### 5. Create Pull Request
Buat PR via GitHub dengan deskripsi yang jelas tentang perubahan.

### Commit Convention

Gunakan conventional commits:
- `feat:` - Fitur baru
- `fix:` - Bug fix
- `docs:` - Perubahan dokumentasi
- `style:` - Formatting, missing semicolons, dll
- `refactor:` - Code refactoring
- `test:` - Menambah tests
- `chore:` - Maintenance tasks

---

## 📄 License

Proyek ini menggunakan **MIT License**. Lihat file `LICENSE` untuk detail.

---

## 📞 Contact & Support

### Repository
- **GitHub**: [arbasyaa/citara](https://github.com/arbasyaa/citara)
- **Issues**: [GitHub Issues](https://github.com/arbasyaa/citara/issues)

### Development Team
- **Owner**: [@arbasyaa](https://github.com/arbasyaa)
- **Contributors**: Lihat [Contributors](https://github.com/arbasyaa/citara/graphs/contributors)

---

## 🙏 Acknowledgments

Terima kasih kepada:

- **Laravel Framework** - The PHP framework for web artisans
- **TailwindCSS** - Utility-first CSS framework
- **Vite** - Next generation frontend tooling
- **Open Source Community** - Semua package dan library yang digunakan

---

## 📈 Project Status

- ✅ **MVP Completed** - Core features implemented
- ✅ **Admin Panel** - Dual admin system ready
- ✅ **Destinasi Categories** - Wisata & Kuliner supported
- ✅ **Calendar System** - Event management implemented
- 🚧 **API Development** - In progress
- 📝 **Mobile App** - Planned

---

**Dibuat dengan ❤️ untuk Cilacap Tourism and Creative**

*Last Updated: November 20, 2025*
