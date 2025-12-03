@extends('layouts.public')

@section('title', $event['title'])

@push('styles')
<style>
    .hero-detail {
        height: 60vh;
        min-height: 400px;
        position: relative;
        overflow: hidden;
    }
    
    @media (min-width: 768px) {
        .hero-detail {
            height: 70vh;
            min-height: 500px;
        }
    }
    
    .hero-detail::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 150px;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    }
    
    @media (min-width: 768px) {
        .hero-detail::after {
            height: 200px;
        }
    }
    
    .content-card {
        transition: all 0.3s ease;
    }
    
    @media (min-width: 768px) {
        .content-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    }
    
    .related-card { 
        transition: transform .2s ease, background .2s ease; 
        will-change: transform; 
    }
    
    .related-card:hover { 
        background: #F3F4F6; 
        transform: translateX(4px); 
    }
    
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

    .category-festival { background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); }
    .category-workshop { background: linear-gradient(135deg, #10B981 0%, #059669 100%); }
    .category-pameran { background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); }
    .category-konser { background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%); }
    .category-olahraga { background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); }
    .category-budaya { background: linear-gradient(135deg, #EC4899 0%, #DB2777 100%); }
</style>
@endpush

@section('content')
    {{-- Professional Hero with Event Image --}}
    <section class="hero-detail relative">
        <div class="absolute inset-0">
            @if($event['image'])
                <img 
                    src="{{ $event['image'] }}"
                    alt="{{ $event['title'] }}"
                    class="w-full h-full object-cover"
                    loading="eager"
                >
            @else
                <div class="w-full h-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500"></div>
            @endif
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
        
        {{-- Breadcrumb --}}
        <div class="container mx-auto px-4 md:px-6 pt-24 md:pt-32 relative z-10">
            <nav class="breadcrumb inline-flex items-center gap-1 md:gap-2 px-3 md:px-6 py-2 md:py-3 rounded-full text-xs md:text-sm mb-6 md:mb-8 max-w-full overflow-x-auto">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 whitespace-nowrap">Home</a>
                <svg class="w-3 h-3 md:w-4 md:h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('events.calendar') }}" class="text-gray-600 hover:text-blue-600 whitespace-nowrap">Kalender</a>
                <svg class="w-3 h-3 md:w-4 md:h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 font-medium truncate">{{ Str::limit($event['title'], 30) }}</span>
            </nav>
        </div>
        
        {{-- Hero Content --}}
        <div class="absolute bottom-0 left-0 right-0 pb-8 md:pb-12 z-10">
            <div class="container mx-auto px-4 md:px-6">
                <div class="flex flex-wrap items-center gap-2 md:gap-3 mb-3 md:mb-4">
                    <div class="inline-block px-3 md:px-4 py-1.5 md:py-2 category-{{ $event['category'] }} text-white rounded-full font-semibold text-xs md:text-sm shadow-lg">
                        {{ ucfirst($event['category']) }}
                    </div>
                    @if($event['monthName'])
                        <span class="inline-flex items-center px-3 md:px-4 py-1.5 md:py-2 rounded-full text-xs md:text-sm font-semibold bg-white/20 text-white backdrop-blur-sm">
                            <svg class="w-3 h-3 md:w-4 md:h-4 mr-1 md:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $event['monthName'] }} {{ $event['year'] }}
                        </span>
                    @endif
                </div>
                <h1 class="text-3xl md:text-5xl lg:text-7xl font-black text-white mb-3 md:mb-4 leading-tight">
                    {{ $event['title'] }}
                </h1>
                <div class="flex flex-wrap items-center gap-4 md:gap-6 text-white/90 text-sm md:text-base">
                    @if($event['date_range'])
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-lg">{{ $event['date_range'] }}</span>
                        </div>
                    @endif
                    @if($event['location'])
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-lg">{{ $event['location'] }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="container mx-auto px-4 md:px-6 py-8 md:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8 lg:gap-12 items-start">
            {{-- Left Column: Description --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- About Event Section --}}
                <article class="content-card bg-white rounded-2xl shadow-xl p-8 md:p-12">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-black text-gray-900">Tentang Event</h2>
                    </div>
                    @if($event['description'])
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($event['description'])) !!}
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

                {{-- Event Image (if available) --}}
                @if($event['image'])
                    <div class="content-card bg-white rounded-2xl shadow-xl p-8 md:p-12">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-3xl font-black text-gray-900">Foto Event</h2>
                        </div>
                        <div class="rounded-2xl overflow-hidden shadow-lg">
                            <img 
                                src="{{ $event['image'] }}"
                                alt="{{ $event['title'] }}"
                                class="w-full h-auto object-cover"
                            >
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right Column: Sidebar cards --}}
            <aside class="space-y-6 lg:sticky lg:top-24">
                {{-- Event Info Card --}}
                <div class="content-card bg-white rounded-2xl shadow-xl p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Info Event</h3>
                    </div>
                    
                    <div class="space-y-4">
                        {{-- Date --}}
                        @if($event['date_range'])
                            <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl">
                                <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <div class="text-sm text-gray-500 mb-1">Tanggal</div>
                                    <div class="font-semibold text-gray-900">{{ $event['date_range'] }}</div>
                                </div>
                            </div>
                        @endif

                        {{-- Category --}}
                        <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl">
                            <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Kategori</div>
                                <div class="font-semibold text-gray-900">{{ ucfirst($event['category']) }}</div>
                            </div>
                        </div>

                        {{-- Year --}}
                        @if($event['year'])
                            <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl">
                                <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <div class="text-sm text-gray-500 mb-1">Tahun</div>
                                    <div class="font-semibold text-gray-900">{{ $event['year'] }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Location Card --}}
                @if($event['location'] || $event['locationUrl'])
                    <div class="content-card bg-white rounded-2xl shadow-xl p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Lokasi</h3>
                        </div>
                        @if($event['locationAddress'])
                            <p class="text-gray-700 mb-4 leading-relaxed">{{ $event['locationAddress'] }}</p>
                        @elseif($event['location'])
                            <p class="text-gray-700 mb-4 leading-relaxed">{{ $event['location'] }}</p>
                        @endif
                        @if($event['locationUrl'])
                            <a 
                                href="{{ $event['locationUrl'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn-maps inline-flex items-center justify-center gap-2 w-full px-6 py-4 text-white rounded-xl font-bold shadow-lg"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Buka di Google Maps
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Related Events --}}
                @if(isset($relatedEvents) && $relatedEvents->isNotEmpty())
                    <div class="content-card bg-white rounded-2xl shadow-xl p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">
                            Event Lainnya<br/>
                            <span class="text-blue-600">{{ ucfirst($event['category']) }}</span>
                        </h3>
                        <div class="space-y-4">
                            @foreach($relatedEvents as $other)
                                <a href="{{ route('events.show', $other['slug']) }}" class="related-card block p-4 rounded-xl">
                                    <div class="flex items-center gap-4">
                                        @if($other['image'])
                                            <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                                                <img 
                                                    src="{{ $other['image'] }}"
                                                    alt="{{ $other['title'] }}"
                                                    class="w-full h-full object-cover"
                                                    loading="lazy"
                                                >
                                            </div>
                                        @else
                                            <div class="w-20 h-20 flex-shrink-0 rounded-lg bg-gradient-to-br from-blue-400 to-purple-500"></div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-gray-900 mb-1 truncate">{{ $other['title'] }}</h4>
                                            <p class="text-sm text-gray-600">{{ $other['date_range'] }}</p>
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

                {{-- Back to Calendar Button --}}
                <div class="content-card bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl shadow-xl p-8 text-center">
                    <svg class="w-16 h-16 text-white/80 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-white mb-3">Lihat Event Lainnya</h3>
                    <p class="text-white/90 mb-6">Jelajahi berbagai event menarik lainnya di Cilacap</p>
                    <a 
                        href="{{ route('events.calendar') }}"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-blue-600 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all hover:scale-105"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Kalender
                    </a>
                </div>
            </aside>
        </div>
    </section>
@endsection
