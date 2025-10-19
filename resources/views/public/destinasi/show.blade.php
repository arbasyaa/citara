@extends('layouts.public')

@section('title', $destinasi->nama)

@section('content')
    <!-- Hero Image -->
    @if($destinasi->foto->where('apakah_slider_utama', true)->isNotEmpty())
        <div class="relative h-[400px]">
            <img 
                src="{{ Storage::url($destinasi->foto->where('apakah_slider_utama', true)->first()->url) }}"
                alt="{{ $destinasi->nama }}"
                class="w-full h-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6">
                <div class="container mx-auto">
                    <h1 class="text-4xl font-bold text-white mb-2">{{ $destinasi->nama }}</h1>
                    <div class="flex items-center text-white/90">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $destinasi->wilayah->nama }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Tentang Destinasi</h2>
                    <div class="prose max-w-none">
                        {{ $destinasi->deskripsi }}
                    </div>
                </div>

                <!-- Photo Gallery -->
                @if($destinasi->foto->isNotEmpty())
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Galeri Foto</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($destinasi->foto as $foto)
                                <div class="aspect-w-16 aspect-h-9">
                                    <img 
                                        src="{{ Storage::url($foto->url) }}"
                                        alt="{{ $foto->keterangan ?? $destinasi->nama }}"
                                        class="w-full h-full object-cover rounded-lg"
                                    >
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Location Info -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Lokasi</h3>
                    <div class="text-gray-600">
                        <p class="mb-4">{{ $destinasi->alamat_lokasi }}</p>
                        @if($destinasi->url_gmaps)
                            <a 
                                href="{{ $destinasi->url_gmaps }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Buka di Google Maps
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Other Destinations -->
                @if($destinasi->wilayah->destinasi->where('id', '!=', $destinasi->id)->isNotEmpty())
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Destinasi Lainnya di {{ $destinasi->wilayah->nama }}</h3>
                        <div class="space-y-4">
                            @foreach($destinasi->wilayah->destinasi->where('id', '!=', $destinasi->id)->take(3) as $other)
                                <a href="{{ route('destinasi.show', $other->slug) }}" class="block group">
                                    <div class="flex items-center">
                                        @if($other->foto->isNotEmpty())
                                            <img 
                                                src="{{ Storage::url($other->foto->first()->url) }}"
                                                alt="{{ $other->nama }}"
                                                class="w-16 h-16 object-cover rounded"
                                            >
                                        @endif
                                        <div class="ml-4">
                                            <h4 class="text-gray-800 group-hover:text-blue-600">{{ $other->nama }}</h4>
                                            <p class="text-sm text-gray-600">{{ Str::limit($other->deskripsi, 60) }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection