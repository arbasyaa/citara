@extends('layouts.public')

@section('title', $destinasi->nama)

@push('styles')
<style>
    .hero-detail {
        height: 70vh;
        min-height: 500px;
        position: relative;
        overflow: hidden;
    }
    
    .hero-detail::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 200px;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    }
    
    .content-card {
        transition: all 0.3s ease;
    }
    
    .content-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        cursor: pointer;
    }
    
    .gallery-item img {
        transition: transform 0.6s ease;
    }
    
    .gallery-item:hover img {
        transform: scale(1.15);
    }
    
    .gallery-item::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0);
        transition: background 0.3s ease;
    }
    
    .gallery-item:hover::after {
        background: rgba(0, 0, 0, 0.3);
    }
    
    .related-card { transition: transform .2s ease, background .2s ease; will-change: transform; }
    .related-card:hover { background: #F3F4F6; transform: translateX(4px); }
    
    .btn-maps {
        background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        transition: all 0.3s ease;
    }
    
    .btn-maps:hover {
        background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
    }
    
    .breadcrumb {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.9);
    }
</style>
@endpush

@section('content')
    {{-- Professional Hero with Parallax Effect --}}
    @php
        $heroImage = $destinasi->foto->where('apakah_slider_utama', true)->first() 
                     ?? $destinasi->foto->first();
    @endphp
    
    @if($heroImage)
    <section class="hero-detail relative">
            <div class="absolute inset-0">
                <img 
                    src="{{ \App\Services\ImageUrl::url($heroImage->url) }}"
                    alt="{{ $destinasi->nama }}"
                    class="w-full h-full object-cover"
                    loading="eager"
                >
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            
            {{-- Breadcrumb --}}
            <div class="container mx-auto px-6 pt-32 relative z-10">
                <nav class="breadcrumb inline-flex items-center gap-2 px-6 py-3 rounded-full text-sm mb-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600">Home</a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="{{ route('destinasi.index') }}" class="text-gray-600 hover:text-blue-600">Destinasi</a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-900 font-medium">{{ $destinasi->nama }}</span>
                </nav>
            </div>
            
            {{-- Hero Content --}}
            <div class="absolute bottom-0 left-0 right-0 pb-12 z-10">
                <div class="container mx-auto px-6">
                    <div class="inline-block px-4 py-2 bg-blue-600 text-white rounded-full mb-4 font-semibold">
                        {{ $destinasi->wilayah->nama }}
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black text-white mb-4">
                        {{ $destinasi->nama }}
                    </h1>
                    <div class="flex items-center gap-6 text-white/90">
                        @if($destinasi->alamat_lokasi)
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-lg">{{ Str::limit($destinasi->alamat_lokasi, 50) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Main Content --}}
    <section class="container mx-auto px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 items-start">
            {{-- Left Column: Description + Gallery --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- About Section --}}
                <article class="content-card bg-white rounded-2xl shadow-xl p-8 md:p-12">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-black text-gray-900">{{ __('site.about_destination') }}</h2>
                    </div>
                    @if($destinasi->deskripsi)
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {{ $destinasi->deskripsi }}
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-sm">Deskripsi belum tersedia</p>
                        </div>
                    @endif
                </article>

                {{-- Photo Gallery (always below description) --}}
                @if($destinasi->foto->isNotEmpty())
                    <div class="content-card bg-white rounded-2xl shadow-xl p-8 md:p-12">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-3xl font-black text-gray-900">{{ __('site.photo_gallery') }}</h2>
                        </div>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($destinasi->foto as $foto)
                                        <div class="gallery-item bg-gray-100" style="aspect-ratio: 16/10;">
                                            <img 
                                                src="{{ \App\Services\ImageUrl::url($foto->url) }}"
                                                alt="{{ $foto->keterangan ?? $destinasi->nama }}"
                                                class="w-full h-full object-cover"
                                            >
                                        </div>
                                    @endforeach
                                </div>
                    </div>
                @endif
            </div>

            {{-- Right Column: Sidebar cards --}}
            <aside class="space-y-6 lg:sticky lg:top-24">
                {{-- Location Card --}}
                <div class="content-card bg-white rounded-2xl shadow-xl p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ __('site.location') }}</h3>
                    </div>
                    <p class="text-gray-700 mb-6 leading-relaxed">{{ $destinasi->alamat_lokasi }}</p>
                    @if($destinasi->url_gmaps)
                        <a 
                            href="{{ $destinasi->url_gmaps }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn-maps inline-flex items-center justify-center gap-2 w-full px-6 py-4 text-white rounded-xl font-bold shadow-lg"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            {{ __('site.open_gmaps') }}
                        </a>
                    @endif
                </div>

                {{-- Related Destinations --}}
                @if($destinasi->wilayah->destinasi->where('id', '!=', $destinasi->id)->isNotEmpty())
                    <div class="content-card bg-white rounded-2xl shadow-xl p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">
                            {{ __('site.other_destinations_in') }}<br/>
                            <span class="text-blue-600">{{ $destinasi->wilayah->nama }}</span>
                        </h3>
                        <div class="space-y-4">
                            @foreach($destinasi->wilayah->destinasi->where('id', '!=', $destinasi->id)->take(4) as $other)
                                <a href="{{ route('destinasi.show', $other->slug) }}" class="related-card block p-4 rounded-xl">
                                    <div class="flex items-center gap-4">
                                        @if($other->foto->isNotEmpty())
                                            <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                                                <img 
                                                    src="{{ \App\Services\ImageUrl::url($other->foto->first()->url) }}"
                                                    alt="{{ $other->nama }}"
                                                    class="w-full h-full object-cover"
                                                    loading="lazy"
                                                >
                                            </div>
                                        @else
                                            <div class="w-20 h-20 flex-shrink-0 rounded-lg bg-gradient-to-br from-blue-400 to-purple-500"></div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-gray-900 mb-1 truncate">{{ $other->nama }}</h4>
                                            <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($other->deskripsi, 60) }}</p>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </section>
@endsection
