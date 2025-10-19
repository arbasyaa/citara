@extends('layouts.public')

@section('title', 'Beranda')

@push('styles')
<style>
    .calendar-section {
        padding: 4rem 0;
        background: #F9FAFB;
    }

    .calendar-container {
        position: relative;
        max-width: 100%;
        margin: 0 auto;
        padding: 0 3rem;
    }

    .months-slider {
        overflow-x: hidden;
        position: relative;
        width: 100%;
    }

    .months-track {
        display: flex;
        gap: 1.5rem;
        transition: transform 0.5s ease;
        width: fit-content;
    }

    .month-card {
        flex: 0 0 300px;
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .month-card:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transform: translateY(-2px);
    }

    .event-item {
        position: relative;
        padding-left: 1rem;
        margin-bottom: 0.75rem;
    }

    .event-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #3B82F6;
        border-radius: 1px;
    }

    .nav-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .nav-button:hover {
        background: #F3F4F6;
    }

    .nav-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: #E5E7EB;
    }

    @media (max-width: 768px) {
        .month-card {
            flex: 0 0 calc(100% - 2rem);
        }
        
        .calendar-container {
            padding: 0 1rem;
        }
    }

    @keyframes zoom {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }
    
    .animate-zoom {
        animation: zoom 20s ease-in-out infinite alternate;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }
    
    .slide-up {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    
    .slide-up.active {
        opacity: 1;
        transform: translateY(0);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .fade-in {
        animation: fadeIn 1.5s ease-out forwards;
    }
    
    .delay-300 { 
        animation-delay: 300ms;
        transition-delay: 300ms; 
    }
    .delay-600 { 
        animation-delay: 600ms;
        transition-delay: 600ms; 
    }
    .delay-900 { 
        animation-delay: 900ms;
        transition-delay: 900ms; 
    }
    
    .backdrop-blur { backdrop-filter: blur(8px); }
    
    .text-shadow {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .card-hover {
        transition: all 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.slide-up').forEach(element => {
        observer.observe(element);
    });
});
</script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const slides = Array.from(document.querySelectorAll('#heroSlides .hero-slide'));
    const cloud = document.getElementById('home-cloud');
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (slides.length === 0) return;

    let current = 0;
    function show(idx){
        slides.forEach((s,i)=>{
            s.classList.toggle('opacity-100', i===idx);
            s.classList.toggle('opacity-0', i!==idx);
        });
    }

    show(0);

    if (!prefersReduced) {
        // hold + fade pattern: holdTime visible, fadeTime for transition
        const holdTime = 5000; // visible duration in ms
        const fadeTime = 1000; // fade duration in ms (matches CSS transition)

        let fadeTimer = null;
        let advanceTimer = null;

        function scheduleNext() {
            // start fade after holdTime
            fadeTimer = setTimeout(() => {
                // trigger fade to next
                const nextIdx = (current + 1) % slides.length;
                // set next slide opacity to 1, current will fade to 0 via CSS
                slides.forEach((s,i)=>{
                    if (i === nextIdx) s.classList.add('opacity-100');
                    if (i === current) s.classList.remove('opacity-100');
                });

                // after fadeTime, advance current and schedule again
                advanceTimer = setTimeout(() => {
                    current = nextIdx;
                    // ensure only current slide has opacity-100
                    slides.forEach((s,i)=>{
                        s.classList.toggle('opacity-100', i===current);
                        s.classList.toggle('opacity-0', i!==current);
                    });
                    scheduleNext();
                }, fadeTime);
            }, holdTime);
        }

        scheduleNext();

        // Cloud subtle motion
        if (cloud) {
            let t = 0;
            function tick(){
                t += 0.003;
                const x = Math.sin(t) * 8; // px
                cloud.style.transform = `translateX(${x}px) scale(1.02)`;
                requestAnimationFrame(tick);
            }
            requestAnimationFrame(tick);
        }
    }
});
</script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const prev = document.getElementById('prevButton');
    const next = document.getElementById('nextButton');
    if (prev && !prev.hasAttribute('data-listener')) {
        prev.addEventListener('click', function() {
            if (typeof window.goPrev === 'function') window.goPrev();
        });
        prev.setAttribute('data-listener', '1');
    }
    if (next && !next.hasAttribute('data-listener')) {
        next.addEventListener('click', function() {
            if (typeof window.goNext === 'function') window.goNext();
        });
        next.setAttribute('data-listener', '1');
    }
});
</script>
@endpush

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="relative min-h-screen flex items-center -mt-24 overflow-hidden">
        {{-- Slides container using featuredDestinations --}}
        <div class="absolute inset-0">
            <div id="heroSlides" class="absolute inset-0">
                @foreach($featuredDestinations as $idx => $dest)
                    @php
                        $foto = $dest->foto->where('apakah_slider_utama', true)->first() ?? $dest->foto->first();
                    @endphp
                    @if($foto)
                        <div class="hero-slide absolute inset-0 transition-opacity {{ $idx === 0 ? 'opacity-100' : 'opacity-0' }} bg-center bg-cover" style="background-image: url('{{ Storage::url($foto->url) }}'); transition: opacity 1s ease;" data-index="{{ $idx }}">
                            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/30 to-black/70 z-10"></div>
                        </div>
                    @endif
                @endforeach
                {{-- Fallback if no slides --}}
                @if($featuredDestinations->isEmpty())
                    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/30 to-black/70 z-10"></div>
                @endif
            </div>
        </div>

        <!-- Hero Content -->
        <div class="container mx-auto px-6 relative z-20">
            <div class="max-w-4xl mx-auto text-center text-white">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 slide-up text-shadow">
                    Jelajahi Keindahan Cilacap
                </h1>
                <p class="text-xl md:text-2xl mb-8 slide-up delay-300 text-shadow">
                    Temukan destinasi wisata menarik, akomodasi nyaman, dan informasi transportasi lengkap untuk perjalanan Anda
                </p>
                <div class="slide-up delay-600">
                    <form action="{{ route('destinasi.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 justify-center mb-8">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari destinasi wisata..."
                            class="flex-1 max-w-xl px-6 py-4 rounded-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg"
                        >
                        <button type="submit" class="md:w-auto w-full px-12 py-4 bg-blue-600 text-white rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg font-medium transition-transform hover:scale-105">
                            Mulai Menjelajah
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-float">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>

        {{-- Decorative cloud below hero --}}
        <div class="absolute left-0 right-0 bottom-0 pointer-events-none -mb-20 flex justify-center z-10">
            <svg id="home-cloud" class="w-[140%] max-w-none opacity-90 transform-gpu transition-transform duration-1000" viewBox="0 0 1200 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <defs>
                    <linearGradient id="cloudGrad" x1="0" x2="1">
                        <stop offset="0%" stop-color="#ffffff" stop-opacity="0.95" />
                        <stop offset="100%" stop-color="#e6f3ff" stop-opacity="0.9" />
                    </linearGradient>
                </defs>
                <path fill="url(#cloudGrad)" d="M0 80 C150 20, 350 20, 500 80 C650 140, 850 140, 1000 80 C1100 40, 1200 60, 1200 60 L1200 400 L0 400 Z"></path>
            </svg>
        </div>
    </section>

    <!-- Featured Destinations Section -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 slide-up">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Destinasi Unggulan dan Populer</h2>
                <p class="text-xl text-gray-600">Temukan tempat-tempat menarik yang wajib Anda kunjungi di Cilacap</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredDestinations->merge($popularDestinasi)->unique('id')->take(8) as $destinasi)
                    <a href="{{ route('destinasi.show', $destinasi->slug) }}" class="bg-white rounded-xl shadow-lg overflow-hidden group card-hover">
                        <div class="relative h-64 overflow-hidden">
                            @if($destinasi->foto->isNotEmpty())
                                <img 
                                    src="{{ Storage::url($destinasi->foto->first()->url) }}"
                                    alt="{{ $destinasi->nama }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                >
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="absolute bottom-4 left-4">
                                    <span class="inline-block px-3 py-1 bg-blue-600/80 backdrop-blur text-white text-sm font-medium rounded-full">
                                        {{ $destinasi->wilayah->nama }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                {{ $destinasi->nama }}
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                                {{ Str::limit($destinasi->deskripsi, 100) }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Tourism Areas Section -->
    <section class="py-24 bg-gray-50 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent"></div>
        <div class="container mx-auto px-6 relative">
            <div class="text-center mb-16 slide-up">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Wilayah Wisata</h2>
                <p class="text-xl text-gray-600">Jelajahi berbagai wilayah wisata di Cilacap</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($wilayah as $area)
                    <a href="{{ route('wilayah.show', $area->slug) }}" class="group">
                        <div class="bg-white rounded-xl p-8 shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                            <div class="w-16 h-16 mb-6 bg-blue-100 rounded-xl flex items-center justify-center transition-colors group-hover:bg-blue-600">
                                <svg class="w-8 h-8 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-3">
                                {{ $area->nama }}
                            </h3>
                            <p class="text-gray-600 mb-6 line-clamp-3">{{ $area->deskripsi }}</p>
                            <div class="flex items-center text-blue-600">
                                <span class="font-medium">{{ $area->destinasi_count }} Destinasi</span>
                                <svg class="w-5 h-5 ml-2 transform transition-transform group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Calendar Section -->
    <section class="py-24 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Kalendar Kegiatan 2026</h2>
                <p class="text-xl text-gray-600">Jelajahi berbagai acara dan kegiatan wisata di Cilacap sepanjang tahun</p>
            </div>

            <div class="calendar-container mx-auto max-w-7xl relative">
                <!-- Navigation Buttons -->
                <button type="button" id="prevButton" class="nav-button absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 p-3 bg-white rounded-full shadow-lg text-gray-600 hover:text-gray-800 hover:bg-gray-50 transition-all z-30 disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button type="button" id="nextButton" class="nav-button absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 p-3 bg-white rounded-full shadow-lg text-gray-600 hover:text-gray-800 hover:bg-gray-50 transition-all z-30 disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Calendar Container with Horizontal Layout -->
                <div class="overflow-hidden">
                    <div id="monthsContainer" class="flex gap-6 transition-transform duration-500 ease-in-out">
                        <!-- January -->
                        <div class="month-card flex-shrink-0 w-80 bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group">
                            <div class="relative">
                                <p class="text-gray-400 text-sm font-medium mb-2">2026</p>
                                <h4 class="text-2xl font-semibold text-gray-900 mb-6">Januari</h4>
                                <div class="space-y-4">
                                    <div class="border-l-2 border-blue-500 pl-4">
                                        <p class="text-sm font-medium text-blue-600 mb-1">01-03</p>
                                        <p class="text-gray-900">Festival Tahun Baru</p>
                                    </div>
                                    <div class="border-l-2 border-blue-500 pl-4">
                                        <p class="text-sm font-medium text-blue-600 mb-1">15-16</p>
                                        <p class="text-gray-900">Pameran Kuliner Tradisional</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- February -->
                        <div class="month-card flex-shrink-0 w-80 bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group">
                            <div class="relative">
                                <p class="text-gray-400 text-sm font-medium mb-2">2026</p>
                                <h4 class="text-2xl font-semibold text-gray-900 mb-6">Februari</h4>
                                <div class="space-y-4">
                                    <div class="border-l-2 border-blue-500 pl-4">
                                        <p class="text-sm font-medium text-blue-600 mb-1">10-12</p>
                                        <p class="text-gray-900">Festival Seni Budaya</p>
                                    </div>
                                    <div class="border-l-2 border-blue-500 pl-4">
                                        <p class="text-sm font-medium text-blue-600 mb-1">25-26</p>
                                        <p class="text-gray-900">Karnaval Budaya</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                                <div class="month-card flex-shrink-0 w-80 bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group">
                                    <div class="relative">
                                        <p class="text-gray-400 text-sm font-medium mb-2">2026</p>
                                        <h4 class="text-2xl font-semibold text-gray-900 mb-6">Maret</h4>
                                        <div class="space-y-4">
                                            <div class="border-l-2 border-blue-500 pl-4">
                                                <p class="text-sm font-medium text-blue-600 mb-1">05-07</p>
                                                <p class="text-gray-900">Festival Seafood</p>
                                            </div>
                                            <div class="border-l-2 border-blue-500 pl-4">
                                                <p class="text-sm font-medium text-blue-600 mb-1">20-21</p>
                                                <p class="text-gray-900">Pameran Kerajinan</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- April -->
                                <div class="month-card flex-shrink-0 w-80 bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group">
                                    <div class="relative">
                                        <p class="text-gray-400 text-sm font-medium mb-2">2026</p>
                                        <h4 class="text-2xl font-semibold text-gray-900 mb-6">April</h4>
                                        <div class="space-y-4">
                                            <div class="border-l-2 border-blue-500 pl-4">
                                                <p class="text-sm font-medium text-blue-600 mb-1">12-14</p>
                                                <p class="text-gray-900">Festival Musik Tradisional</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- May - December (continue cards) -->
                                <div class="month-card flex-shrink-0 w-80 bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group">
                                    <div class="relative">
                                        <p class="text-gray-400 text-sm font-medium mb-2">2026</p>
                                        <h4 class="text-2xl font-semibold text-gray-900 mb-6">Mei</h4>
                                        <div class="space-y-4">
                                            <div class="border-l-2 border-blue-500 pl-4">
                                                <p class="text-sm font-medium text-blue-600 mb-1">18-19</p>
                                                <p class="text-gray-900">Festival Pantai</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="month-card flex-shrink-0 w-80 bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group">
                                    <div class="relative">
                                        <p class="text-gray-400 text-sm font-medium mb-2">2026</p>
                                        <h4 class="text-2xl font-semibold text-gray-900 mb-6">Juni</h4>
                                        <div class="space-y-4">
                                            <div class="border-l-2 border-blue-500 pl-4">
                                                <p class="text-sm font-medium text-blue-600 mb-1">08-10</p>
                                                <p class="text-gray-900">Festival Seni Rupa</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="month-card flex-shrink-0 w-80 bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group">
                                    <div class="relative">
                                        <p class="text-gray-400 text-sm font-medium mb-2">2026</p>
                                        <h4 class="text-2xl font-semibold text-gray-900 mb-6">Juli</h4>
                                        <div class="space-y-4">
                                            <div class="border-l-2 border-blue-500 pl-4">
                                                <p class="text-sm font-medium text-blue-600 mb-1">05-07</p>
                                                <p class="text-gray-900">Festival Film</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="month-card flex-shrink-0 w-80 bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group">
                                    <div class="relative">
                                        <p class="text-gray-400 text-sm font-medium mb-2">2026</p>
                                        <h4 class="text-2xl font-semibold text-gray-900 mb-6">Agustus</h4>
                                        <div class="space-y-4">
                                            <div class="border-l-2 border-blue-500 pl-4">
                                                <p class="text-sm font-medium text-blue-600 mb-1">17-19</p>
                                                <p class="text-gray-900">Festival Kearifan Lokal</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="month-card flex-shrink-0 w-80 bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group">
                                    <div class="relative">
                                        <p class="text-gray-400 text-sm font-medium mb-2">2026</p>
                                        <h4 class="text-2xl font-semibold text-gray-900 mb-6">September</h4>
                                        <div class="space-y-4">
                                            <div class="border-l-2 border-blue-500 pl-4">
                                                <p class="text-sm font-medium text-blue-600 mb-1">10-12</p>
                                                <p class="text-gray-900">Festival Ekonomi Kreatif</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="month-card flex-shrink-0 w-80 bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group">
                                    <div class="relative">
                                        <p class="text-gray-400 text-sm font-medium mb-2">2026</p>
                                        <h4 class="text-2xl font-semibold text-gray-900 mb-6">Oktober</h4>
                                        <div class="space-y-4">
                                            <div class="border-l-2 border-blue-500 pl-4">
                                                <p class="text-sm font-medium text-blue-600 mb-1">05-07</p>
                                                <p class="text-gray-900">Festival Kuliner</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="month-card flex-shrink-0 w-80 bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group">
                                    <div class="relative">
                                        <p class="text-gray-400 text-sm font-medium mb-2">2026</p>
                                        <h4 class="text-2xl font-semibold text-gray-900 mb-6">November</h4>
                                        <div class="space-y-4">
                                            <div class="border-l-2 border-blue-500 pl-4">
                                                <p class="text-sm font-medium text-blue-600 mb-1">20-22</p>
                                                <p class="text-gray-900">Festival Tradisional</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="month-card flex-shrink-0 w-80 bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group">
                                    <div class="relative">
                                        <p class="text-gray-400 text-sm font-medium mb-2">2026</p>
                                        <h4 class="text-2xl font-semibold text-gray-900 mb-6">Desember</h4>
                                        <div class="space-y-4">
                                            <div class="border-l-2 border-blue-500 pl-4">
                                                <p class="text-sm font-medium text-blue-600 mb-1">25-31</p>
                                                <p class="text-gray-900">Festival Tahun Baru</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Add small gap and position nav buttons within calendar container -->
                    </div>

                    <!-- Move Layanan Kami to its own section just before footer -->
            </section>

            <!-- Layanan Kami (separate section, immediately before footer) -->
            <section id="layananKami" class="py-12 bg-white">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-bold text-gray-900">Layanan Kami</h2>
                        <p class="text-gray-600 mt-2">Temukan berbagai fasilitas dan layanan untuk perjalanan Anda</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <a href="#" class="block rounded-lg overflow-hidden">
                            <div class="service-card p-6 bg-gray-50 rounded-lg shadow-sm">
                            <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center mb-4">
                                <!-- icon -->
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Panduan Wisata</h3>
                            <p class="text-gray-600">Informasi lengkap tentang destinasi wisata, rute, dan tips perjalanan yang bermanfaat.</p>
                            </div>
                        </a>
                        <a href="#" class="block rounded-lg overflow-hidden">
                            <div class="service-card p-6 bg-gray-50 rounded-lg shadow-sm">
                            <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Akomodasi</h3>
                            <p class="text-gray-600">Pilihan akomodasi nyaman untuk setiap budget, dari hotel berbintang hingga homestay.</p>
                            </div>
                        </a>
                        <a href="#" class="block rounded-lg overflow-hidden">
                            <div class="service-card p-6 bg-gray-50 rounded-lg shadow-sm">
                            <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2z"/></svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Transportasi</h3>
                            <p class="text-gray-600">Informasi transportasi lengkap untuk memudahkan perjalanan Anda ke setiap destinasi.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
@endsection

@push('styles')
<style>
    .month-card {
        width: calc(33.333% - 1rem);
        min-width: calc(33.333% - 1rem);
        transition: transform 240ms cubic-bezier(.2,.9,.2,1), box-shadow 240ms ease, opacity 240ms ease;
    }
    
    .month-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08), 0 2px 6px rgba(15,23,42,0.04);
    }

    .month-card:active {
        transform: translateY(-2px);
    }

    /* Nav button visual polish */
    .nav-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 9999px;
        transition: transform 150ms ease, box-shadow 150ms ease, background-color 150ms ease;
    }

    .nav-button:hover {
        /* keep hover visual simple - no motion */
        background-color: #f3f4f6;
    }

    .nav-button:active {
        /* no transform/animation on press */
        background-color: #eef2ff;
    }

    /* Service cards subtle hover */
    .service-card {
        transition: transform 240ms cubic-bezier(.2,.9,.2,1), box-shadow 240ms ease, background-color 240ms ease;
    }

    .service-card:hover {
        transform: translateY(-6px);
        background-color: #ffffff;
        box-shadow: 0 10px 20px rgba(2,6,23,0.06), 0 2px 6px rgba(2,6,23,0.04);
    }

    @media (max-width: 768px) {
        .month-card {
            width: calc(100% - 1rem);
            min-width: calc(100% - 1rem);
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const monthsContainer = document.getElementById('monthsContainer');
  const prevButton = document.getElementById('prevButton');
  const nextButton = document.getElementById('nextButton');
    let monthCards = Array.from(document.querySelectorAll('.month-card'));

    if (!monthsContainer || !prevButton || !nextButton) return;

  // Slider state
  let currentIndex = 0;
  let cardsToShow = getCardsToShow();
    // total will be derived from monthCards.length (re-query on resize)
  let isAnimating = false;

  // Read gap between cards (uses CSS gap on flex container)
  function getGap() {
    const style = window.getComputedStyle(monthsContainer);
    const gap = parseFloat(style.gap || style.columnGap || '24') || 24;
    return gap; // px
  }

  function getCardWidth() {
    // use offsetWidth of the first card
    const first = monthCards[0];
    return first ? first.offsetWidth : 0;
  }

  function getCardsToShow() {
    // 3 on desktop, 2 on medium, 1 on small
    const width = window.innerWidth;
    if (width < 640) return 1;
    if (width < 1024) return 2;
    return 3;
  }

    function clampIndex(i) {
        const totalNow = monthCards.length;
        const max = Math.max(0, totalNow - cardsToShow);
        return Math.min(Math.max(0, i), max);
    }

  function updateButtons() {
        const totalNow = monthCards.length;
        const max = Math.max(0, totalNow - cardsToShow);
    prevButton.disabled = currentIndex === 0;
    nextButton.disabled = currentIndex >= max;
    prevButton.setAttribute('aria-disabled', prevButton.disabled);
    nextButton.setAttribute('aria-disabled', nextButton.disabled);
  }

  function updateTrack(animate = true) {
    const w = getCardWidth();
    const gap = getGap();
    const offset = -(currentIndex * (w + gap));
    if (!animate) monthsContainer.style.transition = 'none';
    else monthsContainer.style.transition = '';
    monthsContainer.style.transform = `translateX(${offset}px)`;
    // re-enable transition after forcing none
    if (!animate) requestAnimationFrame(() => {
      monthsContainer.style.transition = '';
    });
    updateButtons();
  }

  function goNext() {
    if (isAnimating) return;
    const target = clampIndex(currentIndex + 1);
    if (target === currentIndex) return;
    isAnimating = true;
    currentIndex = target;
    updateTrack(true);
    setTimeout(() => { isAnimating = false; }, 380);
  }

  function goPrev() {
    if (isAnimating) return;
    const target = clampIndex(currentIndex - 1);
    if (target === currentIndex) return;
    isAnimating = true;
    currentIndex = target;
    updateTrack(true);
    setTimeout(() => { isAnimating = false; }, 380);
  }

  // Button listeners
  prevButton.addEventListener('click', goPrev);
  nextButton.addEventListener('click', goNext);

  // Keyboard support
  prevButton.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); goPrev(); } });
  nextButton.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); goNext(); } });

  // Swipe support for touch
  let startX = 0;
  let isTouching = false;
  monthsContainer.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
    isTouching = true;
  }, { passive: true });
  monthsContainer.addEventListener('touchmove', (e) => {
    if (!isTouching) return;
    const dx = e.touches[0].clientX - startX;
    // allow small dragging UI but don't move the track directly (keeps snapping predictable)
  }, { passive: true });
  monthsContainer.addEventListener('touchend', (e) => {
    if (!isTouching) return;
    const endX = (e.changedTouches && e.changedTouches[0]) ? e.changedTouches[0].clientX : startX;
    const dx = endX - startX;
    const threshold = 40; // px
    if (dx < -threshold) goNext();
    else if (dx > threshold) goPrev();
    isTouching = false;
  });

  // Resize handling
  let resizeTimer = null;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      const prevCardsToShow = cardsToShow;
      cardsToShow = getCardsToShow();
      // If number of visible cards changed, clamp index and update track
      currentIndex = clampIndex(currentIndex);
      updateTrack(false);
      updateButtons();
      // refresh monthCards NodeList in case layout changed
      monthCards = Array.from(document.querySelectorAll('.month-card'));
    }, 120);
  });

    // Initial values
    // refresh card list and initial values
    monthCards = Array.from(document.querySelectorAll('.month-card'));
    cardsToShow = getCardsToShow();
    updateTrack(false);
    updateButtons();

    // Accessibility: add aria labels
    prevButton.setAttribute('aria-label', 'Sebelumnya');
    nextButton.setAttribute('aria-label', 'Berikutnya');
});

// Ensure slider initializes even if script evaluated after DOM ready
if (document.readyState === 'complete' || document.readyState === 'interactive') {
    try { init && init(); } catch(e) { /* init may be encapsulated */ }
}
</script>
@endpush