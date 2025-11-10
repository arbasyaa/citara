# Cilacap Tourism and Creative - Website Pariwisata

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![Vite](https://img.shields.io/badge/Vite-Latest-yellow)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-cyan)

Website pariwisata Cilacap yang menampilkan destinasi wisata, akomodasi, transportasi, dan kalender event dengan dukungan bilingual (Indonesia & English).

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Tujuan Proyek](#-tujuan-proyek)
- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Requirements](#-requirements)
- [Instalasi](#-instalasi)
- [Struktur Database](#-struktur-database)
- [Arsitektur Fitur Bilingual](#-arsitektur-fitur-bilingual)
- [Fitur Admin Panel](#-fitur-admin-panel)
- [Cara Menggunakan](#-cara-menggunakan)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## 🎯 Tentang Proyek

**Cilacap Tourism and Creative** adalah website pariwisata yang dibangun untuk mempromosikan destinasi wisata, akomodasi, transportasi, dan berbagai event di Kabupaten Cilacap. Website ini dilengkapi dengan fitur bilingual (Bahasa Indonesia & English) untuk menarik wisatawan domestik dan internasional.

### Mengapa Proyek Ini Dibuat?

1. **Digitalisasi Pariwisata**: Memudahkan wisatawan menemukan informasi destinasi wisata Cilacap
2. **Jangkauan Internasional**: Dengan dukungan bahasa Inggris, dapat menarik wisatawan mancanegara
3. **Informasi Terpusat**: Menggabungkan data destinasi, akomodasi, transportasi, dan event dalam satu platform
4. **Mudah Dikelola**: Admin panel yang user-friendly untuk manajemen konten

---

## 🎯 Tujuan Proyek

1. **Meningkatkan Kunjungan Wisata**: Memberikan informasi lengkap dan menarik tentang destinasi wisata Cilacap
2. **Memudahkan Wisatawan**: Menyediakan informasi akomodasi dan transportasi yang terintegrasi
3. **Promosi Event**: Menampilkan kalender kegiatan wisata sepanjang tahun
4. **Aksesibilitas Global**: Menyediakan konten dalam dua bahasa (Indonesia & English)
5. **Pengalaman Pengguna Optimal**: Interface yang responsif dan mudah digunakan di berbagai perangkat

---

## ✨ Fitur Utama

### Fitur Publik (Website)

#### 1. **Sistem Bilingual (ID/EN)** 🌍
- Switch bahasa otomatis untuk seluruh konten
- Session-based: pilihan bahasa tersimpan selama browsing
- Fallback mechanism: jika terjemahan English tidak ada, tampilkan Bahasa Indonesia
- Terjemahan UI dan konten database terpisah

#### 2. **Destinasi Wisata** 🏖️
- Daftar lengkap destinasi wisata di Cilacap
- Kategori berdasarkan wilayah
- Galeri foto untuk setiap destinasi
- Deskripsi lengkap (bilingual)
- Integrasi Google Maps untuk lokasi
- Filter destinasi unggulan & populer

#### 3. **Wilayah Wisata** 🗺️
- Pengelompokan destinasi berdasarkan wilayah
- Deskripsi setiap wilayah (bilingual)
- Counter jumlah destinasi per wilayah
- Halaman khusus untuk setiap wilayah

#### 4. **Akomodasi** 🏨
- Daftar hotel, wisma, villa, homestay
- Informasi lokasi dan kontak
- Deskripsi fasilitas (bilingual)
- Kategori berdasarkan tipe akomodasi

#### 5. **Transportasi** 🚌
- Informasi transportasi lokal
- Rute perjalanan
- Deskripsi layanan (bilingual)
- Kategori: Kereta Api, Bus, Pesawat, Transportasi Lokal

#### 6. **Kalender Event 2026** 📅
- Tampilan kalender kegiatan bulanan
- Slider horizontal untuk navigasi bulan
- Event wisata sepanjang tahun
- Informasi tanggal dan nama event

#### 7. **Pencarian** 🔍
- Search bar untuk mencari destinasi
- Filter berdasarkan wilayah
- Hasil pencarian real-time

#### 8. **Responsive Design** 📱
- Tampilan optimal di desktop, tablet, mobile
- Mobile-first approach
- Touch-friendly navigation

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

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/arbasyaa/citara.git
cd citara-dev
```

### 2. Install Dependencies

#### Install PHP Dependencies
```bash
composer install
```

#### Install Node Dependencies
```bash
npm install
```

### 3. Setup Environment

#### Copy .env file
```bash
cp .env.example .env
```

#### Generate Application Key
```bash
php artisan key:generate
```

#### Konfigurasi Database (.env)
```env
APP_NAME="Cilacap Tourism and Creative"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citara_db
DB_USERNAME=root
DB_PASSWORD=

# Session Configuration
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Locale Configuration
APP_LOCALE=id
APP_FALLBACK_LOCALE=id
```

### 4. Database Setup

#### Run Migrations
```bash
php artisan migrate
```

#### (Optional) Seed Data
```bash
php artisan db:seed
```

### 5. Storage Link
```bash
php artisan storage:link
```

### 6. Build Assets

#### Development
```bash
npm run dev
```

#### Production
```bash
npm run build
```

### 7. Run Application

#### Menggunakan Artisan (Development)
```bash
php artisan serve
```

#### Menggunakan Composer Script
```bash
composer run-script dev
```

Website akan berjalan di: `http://localhost:8000`

### 8. Setup Admin Panel

#### Akses Panel
- URL: `http://localhost:8000/panel`
- Password default: Cek di `.env` → `PANEL_PASSWORD`

#### Atau menggunakan Auth Admin
- URL: `http://localhost:8000/admin`
- Register user baru melalui: `php artisan tinker`
```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password')
]);
```

---

## 🗄️ Struktur Database

### Tabel Utama

#### 1. **destinasi**
```sql
- id (bigint, PK)
- id_wilayah (bigint, FK → wilayah)
- nama (varchar 255)
- slug (varchar 255, unique)
- deskripsi (text, nullable)
- deskripsi_en (text, nullable) -- Untuk bilingual
- alamat_lokasi (text, nullable)
- url_gmaps (text, nullable)
- is_popular (tinyint, default 0)
- is_featured (tinyint, default 0)
- timestamps
```

#### 2. **wilayah**
```sql
- id (bigint, PK)
- nama (varchar 255)
- slug (varchar 255, unique)
- deskripsi (text, nullable)
- deskripsi_en (text, nullable) -- Untuk bilingual
- timestamps
```

#### 3. **foto_destinasi**
```sql
- id (bigint, PK)
- id_destinasi (bigint, FK → destinasi)
- url (varchar 255)
- keterangan (text, nullable)
- apakah_slider_utama (boolean, default 0)
- timestamps
```

#### 4. **akomodasi**
```sql
- id (bigint, PK)
- nama (varchar 255)
- tipe (varchar 255, nullable)
- lokasi (text, nullable)
- deskripsi (text, nullable)
- deskripsi_en (text, nullable) -- Untuk bilingual
- nomor_telepon (varchar 50, nullable)
- url_situs_web (text, nullable)
- timestamps
```

#### 5. **transportasi**
```sql
- id (bigint, PK)
- nama (varchar 255)
- tipe (varchar 255, nullable)
- rute (text, nullable)
- deskripsi (text, nullable)
- deskripsi_en (text, nullable) -- Untuk bilingual
- timestamps
```

#### 6. **calendar_events**
```sql
- id (bigint, PK)
- title (varchar 255)
- description (text, nullable)
- event_date (date)
- image (varchar 255, nullable)
- timestamps
```

### Relasi Database
- `destinasi` **belongsTo** `wilayah`
- `wilayah` **hasMany** `destinasi`
- `destinasi` **hasMany** `foto_destinasi`

---

## 🌐 Arsitektur Fitur Bilingual

### Konsep Dasar

Sistem bilingual di proyek ini menggunakan pendekatan **hybrid**:
1. **Database-level**: Konten dinamis (deskripsi destinasi, wilayah, dll) menggunakan kolom terpisah
2. **Translation files**: Teks UI statis (navigasi, tombol, label) menggunakan Laravel translation

### Flow Diagram

```
User clicks EN/ID
       ↓
Session stores locale ('en' atau 'id')
       ↓
Middleware SetLocale runs on every request
       ↓
App::setLocale() sets Laravel locale
       ↓
Views call getTranslatedDescription()
       ↓
Model checks locale and returns appropriate content
       ↓
Display content in selected language
```

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

### Panel CRUD (Lightweight Admin)

#### 1. **Destinasi Management**

**URL**: `/panel/destinasi`

**Fitur:**
- ✅ Daftar semua destinasi
- ✅ Create destinasi baru
- ✅ Edit destinasi existing
- ✅ Hapus destinasi
- ✅ Upload foto destinasi
- ✅ Set foto utama untuk slider
- ✅ **Bilingual**: Form dengan dua field deskripsi (Indonesia & English)
- ✅ **Highlight**: Checkbox "Tandai sebagai Unggulan & Populer"
- ✅ **Lokasi**: Input alamat lokasi & Google Maps URL
- ✅ **Auto-slug**: Generate slug otomatis dari nama

**Form Fields:**
```
- Nama (required)
- Wilayah (dropdown, required)
- Deskripsi (Indonesia) (textarea, optional)
- Deskripsi (English) - optional (textarea, optional)
- Alamat Lokasi (text, optional)
- Google Maps URL (url, optional)
- Tandai sebagai Unggulan & Populer (checkbox)
- Gambar (file upload, optional)
```

**Validator:**
```php
$request->validate([
    'nama' => 'required|string',
    'id_wilayah' => 'nullable|exists:wilayah,id',
    'deskripsi' => 'nullable|string',
    'deskripsi_en' => 'nullable|string',
    'alamat_lokasi' => 'nullable|string',
    'url_gmaps' => 'nullable|url',
    'is_highlight' => 'nullable|boolean',
    'image' => 'nullable|image|max:4096',
]);
```

**Logic Khusus:**
- Jika `is_highlight` checked, set `is_popular=1` dan `is_featured=1`
- Auto-generate slug dari nama destinasi
- Cek duplikat slug, tambahkan counter jika perlu
- Upload gambar ke `storage/app/public/uploads`

#### 2. **Wilayah Management**

**URL**: `/panel/wilayah`

**Fitur:**
- ✅ Daftar semua wilayah
- ✅ Create wilayah baru
- ✅ Edit wilayah
- ✅ Hapus wilayah
- ✅ **Bilingual**: Deskripsi Indonesia & English
- ✅ **Auto-create**: Destinasi placeholder saat create wilayah baru
- ✅ **Counter**: Tampil jumlah destinasi per wilayah

**Form Fields:**
```
- Nama (required)
- Deskripsi (Indonesia) (textarea, optional)
- Deskripsi (English) - optional (textarea, optional)
```

**Logic Khusus:**
- Saat create wilayah baru, otomatis create 1 destinasi placeholder
- Destinasi placeholder: "Destinasi Awal untuk [Nama Wilayah]"
- Tujuan: Agar wilayah langsung muncul di homepage (filter by destinasi_count > 0)

#### 3. **Akomodasi Management**

**URL**: `/panel/akomodasi`

**Fitur:**
- ✅ Daftar akomodasi (hotel, wisma, villa, homestay)
- ✅ CRUD lengkap
- ✅ **Bilingual**: Deskripsi Indonesia & English
- ✅ Informasi kontak (telepon, website)

**Form Fields:**
```
- Nama (required)
- Tipe (Hotel/Wisma/Villa/Homestay)
- Lokasi (text, optional)
- Deskripsi (Indonesia) (textarea, optional)
- Deskripsi (English) - optional (textarea, optional)
- Nomor Telepon (text, optional)
- URL Situs Web (url, optional)
```

#### 4. **Transportasi Management**

**URL**: `/panel/transportasi`

**Fitur:**
- ✅ Daftar transportasi
- ✅ CRUD lengkap
- ✅ **Bilingual**: Deskripsi Indonesia & English
- ✅ Info rute dan tipe

**Form Fields:**
```
- Nama (required)
- Tipe (Kereta Api/Bus/Pesawat/Transportasi Lokal)
- Rute (text, optional)
- Deskripsi (Indonesia) (textarea, optional)
- Deskripsi (English) - optional (textarea, optional)
```

### Workflow Admin

#### Workflow Menambah Destinasi Bilingual

**Langkah-langkah:**

1. **Login ke Panel**
   - Akses: `http://localhost:8000/panel`
   - Masukkan password dari `.env`

2. **Navigasi ke Destinasi**
   - Klik menu "Destinasi"
   - Klik tombol "Tambah Destinasi"

3. **Isi Form**
   - **Nama**: "Pantai Teluk Penyu"
   - **Wilayah**: Pilih "Cilacap Selatan"
   - **Deskripsi**: 
     ```
     Pantai indah dengan pemandangan sunset yang menakjubkan. 
     Lokasi yang tepat untuk bersantai bersama keluarga.
     ```
   - **Deskripsi (English)**:
     ```
     Beautiful beach with stunning sunset views. 
     Perfect spot to relax with family.
     ```
   - **Alamat Lokasi**: "Jl. Yos Sudarso, Cilacap Selatan"
   - **Google Maps URL**: "https://maps.google.com/..."
   - **Unggulan & Populer**: ✓ (centang jika ingin highlight)
   - **Upload Gambar**: Pilih file foto destinasi

4. **Simpan**
   - Klik "Create"
   - Sistem akan:
     - Generate slug: "pantai-teluk-penyu"
     - Simpan data ke database
     - Upload gambar ke storage
     - Create record foto_destinasi
     - Set is_popular & is_featured jika checked

5. **Hasil**
   - Destinasi muncul di daftar admin
   - Destinasi muncul di homepage (jika di-highlight)
   - Deskripsi otomatis switch sesuai bahasa user

#### Workflow Menambah Terjemahan Nanti

**Skenario**: Admin sudah create destinasi tanpa terjemahan English, ingin tambahkan nanti

**Langkah:**

1. **Edit Destinasi**
   - Buka `/panel/destinasi`
   - Klik "Edit" pada destinasi yang ingin ditambahkan terjemahan

2. **Isi Field English**
   - Field **Deskripsi (English)** masih kosong
   - Tambahkan terjemahan:
     ```
     Historic fort from the Dutch colonial era, built in 1861. 
     A must-visit for history enthusiasts.
     ```

3. **Simpan**
   - Klik "Save"
   - Terjemahan tersimpan

4. **Efek Langsung**
   - User yang pilih English sekarang akan lihat terjemahan baru
   - Sebelumnya (saat English belum ada): User English lihat deskripsi Indonesia (fallback)
   - Sekarang (setelah English ditambahkan): User English lihat deskripsi English
   - User Indonesia tetap lihat deskripsi Indonesia

**Benefit**: Admin bisa terjemahkan konten **secara bertahap** tanpa harus langsung semua!

### Best Practices untuk Admin

#### 1. **Apa yang Harus Diterjemahkan?**

✅ **Prioritas Tinggi (Terjemahkan Dulu):**
- Deskripsi destinasi populer/featured
- Deskripsi wilayah utama
- Informasi penting yang dilihat banyak wisatawan

✅ **Prioritas Sedang:**
- Deskripsi destinasi sekunder
- Deskripsi akomodasi
- Deskripsi transportasi

✅ **Prioritas Rendah:**
- Konten arsip
- Destinasi yang jarang dikunjungi

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

## 📖 Cara Menggunakan

### Untuk End User (Wisatawan)

#### 1. **Menjelajah Website**

**Homepage:**
- Lihat destinasi unggulan & populer
- Jelajahi wilayah wisata
- Cek kalender event 2026

**Search Destinasi:**
- Gunakan search bar di hero section
- Ketik nama destinasi atau kata kunci
- Filter berdasarkan wilayah

**Switch Bahasa:**
- Klik tombol "EN" atau "ID" di navbar kanan atas
- Seluruh konten otomatis berubah
- Pilihan bahasa tersimpan selama sesi browsing

#### 2. **Melihat Detail Destinasi**

**Cara:**
- Klik card destinasi di homepage atau halaman destinasi
- Akan terbuka halaman detail dengan:
  - Hero image besar
  - Deskripsi lengkap (sesuai bahasa pilihan)
  - Galeri foto
  - Informasi lokasi
  - Link Google Maps
  - Destinasi lain di wilayah yang sama

#### 3. **Eksplorasi Berdasarkan Wilayah**

**Cara:**
- Di homepage, bagian "Wilayah Wisata"
- Klik card wilayah
- Lihat semua destinasi di wilayah tersebut

### Untuk Admin/Pengelola Konten

#### 1. **Login Admin**

**Panel (Simple):**
```
URL: http://localhost:8000/panel
Password: [check .env → PANEL_PASSWORD]
```

**Admin (Full Auth):**
```
URL: http://localhost:8000/admin
Email: admin@example.com
Password: [your password]
```

#### 2. **Mengelola Destinasi**

**Create Destinasi:**
1. Panel → Destinasi → Tambah Destinasi
2. Isi semua field (minimal Nama dan Wilayah)
3. **Penting**: Isi Deskripsi Indonesia & English
4. Upload foto (recommended)
5. Centang "Unggulan & Populer" jika ingin highlight
6. Save

**Edit Destinasi:**
1. Panel → Destinasi → Klik Edit
2. Update informasi
3. Bisa tambah terjemahan English nanti
4. Save

**Hapus Destinasi:**
1. Panel → Destinasi → Klik Delete
2. Confirm deletion

#### 3. **Mengelola Wilayah**

**Create Wilayah:**
1. Panel → Wilayah → Tambah Wilayah
2. Isi Nama & Deskripsi (bilingual)
3. Save
4. Sistem otomatis create destinasi placeholder

**Best Practice:**
- Buat wilayah dulu sebelum destinasi
- Isi deskripsi wilayah yang informatif
- Tambahkan terjemahan English untuk wilayah utama

#### 4. **Mengelola Konten Lainnya**

**Akomodasi:**
- Panel → Akomodasi
- Tambah hotel/wisma/villa/homestay
- Isi deskripsi, lokasi, kontak

**Transportasi:**
- Panel → Transportasi
- Tambah info kereta/bus/pesawat
- Isi rute dan deskripsi layanan

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

## 🚀 Deployment

### Persiapan Production

#### 1. **Environment Configuration**

Update `.env` untuk production:

```env
APP_NAME="Cilacap Tourism and Creative"
APP_ENV=production
APP_KEY=base64:...  # Generate dengan: php artisan key:generate
APP_DEBUG=false
APP_URL=https://cilaceptourism.com

# Database Production
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citara_production
DB_USERNAME=citara_user
DB_PASSWORD=strong_password_here

# Session Driver (gunakan database atau redis di production)
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Cache Driver
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
```

#### 2. **Optimize untuk Production**

```bash
# Clear semua cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cache config dan routes
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize composer autoloader
composer install --optimize-autoloader --no-dev

# Build production assets
npm run build
```

#### 3. **Set Permissions**

```bash
# Set ownership
sudo chown -R www-data:www-data /path/to/citara-dev

# Set directory permissions
sudo find /path/to/citara-dev -type d -exec chmod 755 {} \;

# Set file permissions
sudo find /path/to/citara-dev -type f -exec chmod 644 {} \;

# Set storage dan bootstrap/cache writable
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
```

---

## 🤝 Kontribusi

Kami menerima kontribusi dari developer lain! Berikut panduan kontribusi:

### Cara Berkontribusi

1. **Fork Repository**
```bash
# Fork via GitHub UI, lalu clone
git clone https://github.com/YOUR_USERNAME/citara.git
```

2. **Create Branch Baru**
```bash
git checkout -b feature/nama-fitur
# atau
git checkout -b fix/nama-bug
```

3. **Develop & Test**
```bash
# Develop fitur/fix
# Run tests
php artisan test

# Check code style
./vendor/bin/pint
```

4. **Commit Changes**
```bash
git add .
git commit -m "feat: tambah fitur bilingual untuk event"
# atau
git commit -m "fix: perbaiki fallback mechanism di transportasi"
```

5. **Push & Create PR**
```bash
git push origin feature/nama-fitur
# Create Pull Request via GitHub
```

---

## 📄 Lisensi

Proyek ini menggunakan lisensi **MIT License**.

---

## 📞 Kontak & Support

### Tim Development
- **Email**: dev@cilaceptourism.com
- **GitHub**: https://github.com/arbasyaa/citara

### Laporkan Bug
- **GitHub Issues**: https://github.com/arbasyaa/citara/issues

---

## 🙏 Acknowledgments

Terima kasih kepada:

- **Laravel Team** - Framework yang luar biasa
- **TailwindCSS Team** - Utility CSS yang powerful
- **Open Source Community** - Packages dan libraries yang membantu

---

**Dibuat dengan ❤️ untuk Cilacap Tourism**

*Last Updated: November 2025*

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
