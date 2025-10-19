@extends('layouts.public')

@section('title', 'Destinasi di ' . $wilayah->nama)

@section('content')
    <!-- Hero Section -->
    <div class="bg-gray-900 py-12">
        <div class="container mx-auto px-6">
            <h1 class="text-4xl font-bold text-white mb-4">Destinasi di {{ $wilayah->nama }}</h1>
            <p class="text-xl text-gray-300">{{ $wilayah->deskripsi }}</p>
        </div>
    </div>

    <!-- Destinations Grid -->
    <div class="container mx-auto px-6 py-12">
        @if($destinasi->isEmpty())
            <div class="text-center py-12">
                <h3 class="text-xl text-gray-600">Belum ada destinasi di wilayah ini</h3>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($destinasi as $dest)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        @if($dest->foto->isNotEmpty())
                            <img 
                                src="{{ Storage::url($dest->foto->first()->url) }}"
                                alt="{{ $dest->nama }}"
                                class="w-full h-48 object-cover"
                            >
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">
                                {{ $dest->nama }}
                            </h3>
                            <p class="text-gray-600 mb-4">
                                {{ Str::limit($dest->deskripsi, 150) }}
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-gray-500">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="text-sm">{{ Str::limit($dest->alamat_lokasi, 30) }}</span>
                                </div>
                                <a 
                                    href="{{ route('destinasi.show', $dest->slug) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium"
                                >
                                    Detail →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $destinasi->links() }}
            </div>
        @endif
    </div>
@endsection