@extends('layouts.admin')

@section('page-title', 'Tambah Wilayah Wisata Baru')

@section('breadcrumb')
    <a href="{{ route('panel.wilayah.index') }}" class="hover:text-indigo-600">Wilayah Wisata</a>
    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-gray-900 font-medium">Buat Baru</span>
@endsection

@section('content')
<form method="POST" action="{{ route('panel.wilayah.store') }}" class="max-w-4xl">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 admin-card">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Area Information</h2>
                    <p class="text-sm text-gray-600 mt-1">Detail dasar tentang wilayah wisata ini</p>
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
                                Area Nama (Bahasa Indonesia) <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="nama" 
                                value="{{ old('nama') }}" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all" 
                                placeholder="e.g., Pantai Teluk Penyu"
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
                                placeholder="Deskripsikan wilayah wisata ini dalam bahasa Indonesia..."
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
                                Area Nama (Bahasa Inggris)
                                <span class="ml-2 text-xs font-normal text-gray-500">Opsional - Akan menggunakan bahasa Indonesia jika kosong</span>
                            </label>
                            <input 
                                type="text" 
                                name="nama_en" 
                                value="{{ old('nama_en') }}" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all" 
                                placeholder="e.g., Teluk Penyu Beach"
                            >
                            <p class="mt-1 text-xs text-gray-500">💡 Terjemahan bahasa Inggris untuk pengunjung internasional</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (Bahasa Inggris)</label>
                            <textarea 
                                name="deskripsi_en" 
                                rows="5" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                                placeholder="Deskripsikan wilayah wisata ini dalam bahasa Inggris..."
                            >{{ old('deskripsi_en') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Slug
                            <span class="ml-2 text-xs font-normal text-gray-500">Optional - Auto-generated from name</span>
                        </label>
                        <input 
                            type="text" 
                            name="slug" 
                            value="{{ old('slug') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all" 
                            placeholder="e.g., pantai-teluk-penyu"
                        >
                        <p class="mt-1 text-xs text-gray-500">Used in URL. Leave empty for auto-generation.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
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
                        Create Area
                    </button>
                    
                    <a 
                        href="{{ route('panel.wilayah.index') }}" 
                        class="w-full px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors flex items-center justify-center gap-2"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Cancel
                    </a>
                </div>

                <div class="px-6 pb-6">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <p class="text-xs text-blue-800 font-medium mb-1">💡 Quick Tip</p>
                        <p class="text-xs text-blue-700">After creating an area, you can add destinations to it from the Destinations page.</p>
                    </div>
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

// Initialize tabs
document.addEventListener('DOMContentLoaded', () => {
    const firstTab = document.querySelector('.lang-tab[data-lang="id"]');
    if (firstTab) {
        firstTab.classList.add('border-indigo-600', 'text-indigo-600');
    }
});
</script>
@endsection
