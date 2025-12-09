@extends('layouts.admin')

@section('page-title', 'Tambah Destinasi Baru')

@section('breadcrumb')
    <a href="{{ route('panel.destinasi.index') }}" class="hover:text-indigo-600">Destinasi</a>
    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-gray-900 font-medium">Buat Baru</span>
@endsection

@section('content')
<form method="POST" action="{{ route('panel.destinasi.store') }}" enctype="multipart/form-data" class="max-w-5xl">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Basic Information Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 admin-card">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Informasi Dasar</h2>
                    <p class="text-sm text-gray-600 mt-1">Detail utama tentang destinasi</p>
                </div>
                
                <div class="p-6">
                    {{-- Language Tabs --}}
                    <div class="mb-6">
                        <div class="flex gap-2 border-b border-gray-200">
                            <button type="button" onclick="switchLang('id')" class="lang-tab px-4 py-2 font-medium text-sm border-b-2 transition-colors active" data-lang="id">
                                🇮🇩 Bahasa Indonesia
                            </button>
                            <button type="button" onclick="switchLang('en')" class="lang-tab px-4 py-2 font-medium text-sm border-b-2 transition-colors" data-lang="en">
                                🇬🇧 Bahasa Inggris
                            </button>
                        </div>
                    </div>

                    {{-- Indonesian Content --}}
                    <div class="lang-content space-y-4" data-lang="id">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama (Bahasa Indonesia) <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="nama" 
                                value="{{ old('nama') }}" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all" 
                                placeholder="Masukkan nama destinasi dalam bahasa Indonesia"
                                required
                            >
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (Bahasa Indonesia)</label>
                            <textarea 
                                name="deskripsi" 
                                rows="5" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                                placeholder="Deskripsikan destinasi ini dalam bahasa Indonesia..."
                            >{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- English Content --}}
                    <div class="lang-content space-y-4 hidden" data-lang="en">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama (Bahasa Inggris)
                                <span class="ml-2 text-xs font-normal text-gray-500">Opsional - Akan menggunakan bahasa Indonesia jika kosong</span>
                            </label>
                            <input 
                                type="text" 
                                name="nama_en" 
                                value="{{ old('nama_en') }}" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all" 
                                placeholder="Masukkan nama destinasi dalam bahasa Inggris"
                            >
                            <p class="mt-1 text-xs text-gray-500">💡 Terjemahan bahasa Inggris untuk pengunjung internasional</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (Bahasa Inggris)</label>
                            <textarea 
                                name="deskripsi_en" 
                                rows="5" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                                placeholder="Deskripsikan destinasi ini dalam bahasa Inggris..."
                            >{{ old('deskripsi_en') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lokasi Location & Maps Peta Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 admin-card">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Lokasi Location & Maps Peta</h2>
                    <p class="text-sm text-gray-600 mt-1">Alamat dan informasi Google Maps</p>
                </div>
                
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat / Deskripsi Lokasi</label>
                        <input 
                            type="text" 
                            name="alamat_lokasi" 
                            value="{{ old('alamat_lokasi') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                            placeholder="e.g., Jl. Raya Cilacap No. 123, Kecamatan..."
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Google Maps URL</label>
                        <input 
                            type="url" 
                            name="url_gmaps" 
                            value="{{ old('url_gmaps') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                            placeholder="https://maps.google.com/..."
                        >
                        <p class="mt-1 text-xs text-gray-500">💡 Get from Google Maps "Share" → "Copy link"</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Actions Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 admin-card sticky top-24">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Actions</h2>
                </div>
                
                <div class="p-6 space-y-3">
                    <button 
                        type="submit" 
                        class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold shadow-lg shadow-indigo-500/50 hover:shadow-xl hover:scale-105 transition-all flex items-center justify-center gap-2"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Create Destination
                    </button>
                    
                    <a 
                        href="{{ route('panel.destinasi.index') }}" 
                        class="w-full px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors flex items-center justify-center gap-2"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Cancel
                    </a>
                </div>
            </div>

            {{-- Settings Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 admin-card">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Pengaturan</h2>
                </div>
                
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Type <span class="text-red-500">*</span></label>
                        <select 
                            name="tipe" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all" 
                            required
                        >
                            <option value="">-- Select Type --</option>
                            <option value="wisata" {{ old('tipe') === 'wisata' ? 'selected' : '' }}>🏖️ Wisata</option>
                            <option value="kuliner" {{ old('tipe') === 'kuliner' ? 'selected' : '' }}>🍜 Kuliner</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Wilayah Wisata</label>
                        <select 
                            name="id_wilayah" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                        >
                            <option value="">-- Select Area --</option>
                            @foreach(\App\Models\Wilayah::all() as $w)
                                <option value="{{ $w->id }}" {{ old('id_wilayah') == $w->id ? 'selected' : '' }}>
                                    {{ $w->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input 
                                    type="checkbox" 
                                    name="is_highlight" 
                                    value="1" 
                                    class="peer sr-only"
                                    {{ old('is_highlight') ? 'checked' : '' }}
                                >
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-indigo-600 transition-colors"></div>
                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-5"></div>
                            </div>
                            <div>
                                <span class="text-sm font-semibold text-gray-900">Unggulan >Featured & Popular< Populer</span>
                                <p class="text-xs text-gray-500">Tampilkan di beranda</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Upload Photo Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 admin-card">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Unggah Foto</h2>
                    <p class="text-sm text-gray-600 mt-1">Add photo for this destination</p>
                </div>
                
                <div class="p-6">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-indigo-500 transition-colors">
                        <input 
                            type="file" 
                            name="image" 
                            accept="image/*" 
                            class="hidden" 
                            id="imageUpload"
                            onchange="previewImage(event)"
                        >
                        <label for="imageUpload" class="cursor-pointer flex flex-col items-center">
                            <div id="imagePreview" class="mb-4 hidden">
                                <img src="" alt="Preview" class="h-32 w-32 object-cover rounded-lg">
                            </div>
                            <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm font-medium text-gray-900 mb-1">Click to upload photo</p>
                            <p class="text-xs text-gray-500">PNG, JPG, WEBP up to 10MB</p>
                        </label>
                    </div>
                    <p class="mt-3 text-xs text-gray-500">💡 You can add more photos after creating the destination</p>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function switchLang(lang) {
    // Update tabs
    document.querySelectorAll('.lang-tab').forEach(tab => {
        if (tab.dataset.lang === lang) {
            tab.classList.add('active', 'border-indigo-600', 'text-indigo-600');
            tab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700');
        } else {
            tab.classList.remove('active', 'border-indigo-600', 'text-indigo-600');
            tab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700');
        }
    });
    
    // Update content
    document.querySelectorAll('.lang-content').forEach(content => {
        if (content.dataset.lang === lang) {
            content.classList.remove('hidden');
        } else {
            content.classList.add('hidden');
        }
    });
}

function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            const img = preview.querySelector('img');
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

// Initialize tabs
document.addEventListener('DOMContentLoaded', () => {
    const firstTab = document.querySelector('.lang-tab[data-lang="id"]');
    if (firstTab) {
        firstTab.classList.add('border-indigo-600', 'text-indigo-600');
    }
});
</script>
@endsection
