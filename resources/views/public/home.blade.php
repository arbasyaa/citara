@extends('layouts.public')

@section('title', __('site.home'))

@push('styles')
<style>
    /* Professional Portal Styles */
    html, body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .hero-portal {
        position: relative;
        height: 100vh;
        min-height: 700px;
        overflow: hidden;
        display: flex;
        align-items: center;
    }

    .hero-overlay {
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 82, 167, 0.6) 100%);
    }

    .hero-content-wrapper {
        padding: 0 1.5rem;
        width: 100%;
        max-width: 1280px;
        margin: 0 auto;
    }

    .trending-badge {
        background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    .category-tag {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .news-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .news-card:hover .news-image {
        transform: scale(1.08);
    }

    .news-image {
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .featured-large {
        position: relative;
        height: 550px;
    }

    .featured-small {
        height: 265px;
    }

    .gradient-overlay {
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%);
    }

    .stats-counter {
        font-size: 3rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-divider {
        height: 4px;
        width: 60px;
        background: linear-gradient(90deg, #3B82F6, #8B5CF6);
        margin: 0 auto 2rem;
    }

    .area-card {
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        height: 320px;
    }

    .area-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);
        z-index: 1;
    }

    .area-card:hover::before {
        background: linear-gradient(to top, rgba(59, 130, 246,0.9) 0%, rgba(59, 130, 246,0.4) 50%, transparent 100%);
    }

    .area-card img {
        transition: transform 0.7s ease;
    }

    .area-card:hover img {
        transform: scale(1.15);
    }

    .magazine-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 1.5rem;
    }

    .grid-span-6 {
        grid-column: span 6;
    }

    .grid-span-3 {
        grid-column: span 3;
    }

    @media (max-width: 1024px) {
        .grid-span-6, .grid-span-3 {
            grid-column: span 12;
        }
        
        .featured-large, .featured-small {
            height: 400px;
        }
    }

    .event-timeline {
        position: relative;
        padding-left: 2rem;
    }

    .event-timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #3B82F6, #8B5CF6);
    }

    .event-dot {
        position: absolute;
        left: -5px;
        width: 12px;
        height: 12px;
        background: #3B82F6;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #3B82F6;
    }

    .parallax-section {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    /* Respect user reduced motion preferences */
    @media (prefers-reduced-motion: reduce) {
        .news-card, .parallax-card, .parallax-bg, .month-card, .slide-up, .section-reveal {
            transition: none !important;
            animation: none !important;
        }
        .parallax-card .parallax-target { transform: none !important; }
    }

    .floating {
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .text-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
    }

    .search-box {
        backdrop-filter: blur(20px);
        background: rgba(255, 255, 255, 0.95);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .hero-stats {
        backdrop-filter: blur(15px);
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .slide-up {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .slide-up.active {
        opacity: 1;
        transform: translateY(0);
    }

    .delay-100 { transition-delay: 100ms; }
    .delay-200 { transition-delay: 200ms; }
    .delay-300 { transition-delay: 300ms; }
    .delay-400 { transition-delay: 400ms; }

    /* Parallax Effects */
    .parallax-layer {
        will-change: transform;
        transition: transform 0.1s ease-out;
    }

    /* Remove unwanted margins and padding */
    section {
        margin: 0;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    section:first-of-type {
        padding-top: 0;
        margin-top: 0;
    }
    
    /* Tighter spacing for event section */
    .events-section {
        padding-top: 1.25rem !important;
        padding-bottom: 1.25rem !important;
    }
    
    /* Reduce bottom padding for tourism section */
    .tourism-section {
        padding-bottom: 1rem !important;
    }

    /* Call-to-action compact spacing */
    .cta-section {
        padding-top: 2rem !important;
        padding-bottom: 2rem !important;
    }

    /* Month scroller styles */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .month-scroller {
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }
    .month-card { scroll-snap-align: start; }
    .scroller-nav {
        position: absolute; top: 50%; transform: translateY(-50%);
    }

    /* Section reveal */
    .section-reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; }
    .section-reveal.active { opacity: 1; transform: translateY(0); }
    .section-parallax { position: relative; }
    .section-parallax .parallax-bg { position: absolute; inset: 0; pointer-events: none; }

    /* Card parallax */
    .parallax-card { perspective: 1000px; }
    .parallax-card .parallax-target { will-change: transform; transition: transform 0.2s ease-out; }

    /* Tasteful patterns */
    .pattern-dots { background-image: radial-gradient(rgba(59,130,246,0.12) 1px, transparent 1px); background-size: 22px 22px; }
    .pattern-waves { background-image: repeating-linear-gradient(0deg, rgba(99,102,241,0.08) 0 2px, transparent 2px 10px); }
    .pattern-grid { background-image: linear-gradient(rgba(0,0,0,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.04) 1px, transparent 1px); background-size: 28px 28px; }

    /* Increase vertical spacing for text elements */
    .hero-title {
        line-height: 1.15;
        margin-bottom: 2rem;
    }

    .hero-subtitle {
        line-height: 1.8;
        margin-bottom: 2.5rem;
    }

    /* Better spacing for hero stats */
    .hero-stats-grid {
        margin-top: 3rem;
    }
</style>
@endpush

@section('content')
    {{-- Hero Portal Section with Magazine Style --}}
    <section class="hero-portal relative section-parallax section-reveal active">
    <div class="absolute inset-0 parallax-bg">
            <div id="heroSlides" class="absolute inset-0">
                @foreach($featuredDestinations->take(1) as $idx => $dest)
                    @php
                        $foto = $dest->foto->where('apakah_slider_utama', true)->first() ?? $dest->foto->first();
                    @endphp
                    @if($foto)
                        <div class="absolute inset-0 bg-center bg-cover" style="background-image: url('{{ \App\Services\ImageUrl::url($foto->url) }}');">
                            <div class="hero-overlay absolute inset-0"></div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="hero-content-wrapper relative z-10">
            <div class="max-w-4xl">
                {{-- Trending Badge --}}
                <div class="inline-flex items-center gap-2 trending-badge text-white px-4 py-2 rounded-full mb-6 slide-up">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="font-semibold uppercase tracking-wide text-sm">{{ __('site.featured_popular') }}</span>
                </div>

                {{-- Main Headline --}}
                <h1 class="hero-title text-5xl md:text-7xl lg:text-8xl font-black text-white slide-up delay-100">
                    {{ __('site.hero_title') }}
                </h1>
                
                <p class="hero-subtitle text-xl md:text-2xl text-white/90 slide-up delay-200 max-w-3xl">
                    {{ __('site.hero_subtitle') }}
                </p>

                {{-- Search Box --}}
                <div class="search-box rounded-2xl p-2 max-w-2xl slide-up delay-300 shadow-2xl">
                    <form action="{{ route('destinasi.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="{{ __('site.search_placeholder') }}"
                            class="flex-1 px-6 py-4 rounded-xl text-gray-800 focus:outline-none bg-transparent border-0 text-lg"
                        >
                        <button type="submit" class="btn-primary px-8 py-4 text-white rounded-xl font-semibold text-lg shadow-lg">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                {{ __('site.search') }}
                            </span>
                        </button>
                    </form>
                </div>

                {{-- Hero Stats --}}
                <div class="hero-stats-grid grid grid-cols-3 gap-6 slide-up delay-400">
                    <div class="hero-stats rounded-xl p-6 text-center">
                        <div class="text-4xl font-bold text-white mb-2">{{ $destinasiCount }}</div>
                        <div class="text-white/80 text-sm">{{ __('site.destinations') }}</div>
                    </div>
                    <div class="hero-stats rounded-xl p-6 text-center">
                        <div class="text-4xl font-bold text-white mb-2">{{ $wilayah->count() }}</div>
                        <div class="text-white/80 text-sm">{{ __('site.tourism_areas') }}</div>
                    </div>
                    <div class="hero-stats rounded-xl p-6 text-center">
                        <div class="text-4xl font-bold text-white mb-2">{{ $events->count() }}</div>
                        <div class="text-white/80 text-sm">Events</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 floating z-10">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    {{-- Magazine Style Featured Section --}}
    <section class="bg-gray-50 section-parallax section-reveal">
        <div class="container mx-auto px-6">
            {{-- Section Header --}}
            <div class="text-center mb-10">
                <span class="text-blue-600 font-semibold uppercase tracking-wide text-sm">{{ __('site.featured_popular') }}</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-4 mb-4">
                    {{ __('site.popular_highlight') }}
                </h2>
                <div class="section-divider"></div>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    {{ __('site.featured_popular_subtitle') }}
                </p>
            </div>

            {{-- Magazine Grid Layout --}}
            <div class="magazine-grid">
                {{-- Large Featured Card --}}
                @php
                    // Merge and filter to only admin-flagged destinations (is_featured or is_popular)
                    $adminPicks = $featuredDestinations->merge($popularDestinasi)->unique('id')->filter(function($d){
                        return (isset($d->is_featured) && $d->is_featured) || (isset($d->is_popular) && $d->is_popular);
                    })->values();

                    // Fallback: if admin picks are empty, show popularDestinasi so the section never appears blank
                    if ($adminPicks->isEmpty()) {
                        $adminPicks = $popularDestinasi->values();
                    }
                @endphp

                @if($adminPicks->first())
                    @php $featured = $adminPicks->first(); @endphp
                    <a href="{{ route('destinasi.show', $featured->slug) }}" class="grid-span-6 news-card rounded-2xl overflow-hidden shadow-xl group parallax-card">
                        <div class="featured-large relative">
                            @if($featured->foto->isNotEmpty())
                                <img 
                                    src="{{ \App\Services\ImageUrl::url($featured->foto->first()->url) }}"
                                    alt="{{ $featured->nama }}"
                                    class="news-image w-full h-full object-cover parallax-target"
                                >
                            @endif
                            <div class="gradient-overlay absolute inset-0"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-8 z-10">
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="category-tag px-4 py-1 rounded-full text-white text-sm font-medium">
                                        {{ $featured->wilayah->nama }}
                                    </span>
                                    <span class="trending-badge px-3 py-1 rounded-full text-white text-xs font-bold uppercase">
                                        {{ __('site.featured') }}
                                    </span>
                                </div>
                                <h3 class="text-3xl font-bold text-white mb-3 group-hover:text-blue-300 transition-colors">
                                    {{ $featured->nama }}
                                </h3>
                                <p class="text-white/90 text-lg line-clamp-2">
                                    {{ Str::limit($featured->deskripsi, 150) }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endif

                {{-- Right Column - 2 Medium Cards --}}
                <div class="grid-span-6 space-y-6">
                    @foreach($adminPicks->skip(1)->take(2) as $dest)
                        <a href="{{ route('destinasi.show', $dest->slug) }}" class="news-card rounded-2xl overflow-hidden shadow-lg group block parallax-card">
                            <div class="featured-small relative">
                                @if($dest->foto->isNotEmpty())
                                    <img 
                                        src="{{ \App\Services\ImageUrl::url($dest->foto->first()->url) }}"
                                        alt="{{ $dest->nama }}"
                                        class="news-image w-full h-full object-cover parallax-target"
                                    >
                                @endif
                                <div class="gradient-overlay absolute inset-0"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6 z-10">
                                    <span class="category-tag px-3 py-1 rounded-full text-white text-xs font-medium mb-3 inline-block">
                                        {{ $dest->wilayah->nama }}
                                    </span>
                                    <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-blue-300 transition-colors">
                                        {{ $dest->nama }}
                                    </h3>
                                    <p class="text-white/80 text-sm line-clamp-2">
                                        {{ Str::limit($dest->deskripsi, 100) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Bottom Row - 4 Small Cards --}}
                @foreach($adminPicks->skip(3)->take(4) as $dest)
                    <div class="grid-span-3">
                        <a href="{{ route('destinasi.show', $dest->slug) }}" class="news-card rounded-xl overflow-hidden shadow-lg group block h-full parallax-card">
                            <div class="relative h-48">
                                @if($dest->foto->isNotEmpty())
                                    <img 
                                        src="{{ \App\Services\ImageUrl::url($dest->foto->first()->url) }}"
                                        alt="{{ $dest->nama }}"
                                        class="news-image w-full h-full object-cover parallax-target"
                                    >
                                @endif
                                <div class="gradient-overlay absolute inset-0"></div>
                            </div>
                            <div class="p-5 bg-white">
                                <span class="text-blue-600 text-xs font-semibold uppercase tracking-wide">
                                    {{ $dest->wilayah->nama }}
                                </span>
                                <h3 class="text-lg font-bold text-gray-900 mt-2 group-hover:text-blue-600 transition-colors line-clamp-2">
                                    {{ $dest->nama }}
                                </h3>
                                <p class="text-gray-600 text-sm mt-2 line-clamp-2">
                                    {{ Str::limit($dest->deskripsi, 80) }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- View All Button --}}
            <div class="text-center mt-16">
                <a href="{{ route('destinasi.index') }}" class="btn-primary inline-flex items-center gap-2 px-8 py-4 rounded-xl text-white font-semibold text-lg shadow-lg">
                    {{ __('site.view_all') }} {{ __('site.destinations') }}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Tourism Areas Section with Image Cards --}}
    <section class="bg-white relative overflow-hidden tourism-section section-parallax section-reveal">
        {{-- Background Decoration --}}
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-transparent to-purple-50 opacity-50"></div>
        
        <div class="container mx-auto px-6 relative">
            <div class="text-center mb-10">
                <span class="text-blue-600 font-semibold uppercase tracking-wide text-sm">{{ __('site.tourism_areas') }}</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-4 mb-4">
                    {{ __('site.tourism_areas') }}
                </h2>
                <div class="section-divider"></div>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    {{ __('site.tourism_areas_subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($wilayah as $area)
                    <a href="{{ route('wilayah.show', $area->slug) }}" class="area-card group cursor-pointer parallax-card">
                        @if($area->destinasi->first() && $area->destinasi->first()->foto->isNotEmpty())
                            <img 
                                src="{{ \App\Services\ImageUrl::url($area->destinasi->first()->foto->first()->url) }}"
                                alt="{{ $area->nama }}"
                                class="w-full h-full object-cover parallax-target"
                            >
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500"></div>
                        @endif
                        <div class="absolute inset-0 z-10 p-6 flex flex-col justify-end">
                            <div class="transform transition-transform group-hover:translate-y-[-10px]">
                                <div class="flex items-center gap-2 mb-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="text-white font-medium text-sm">{{ $area->destinasi_count }} Destinasi</span>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-2">
                                    {{ $area->nama }}
                                </h3>
                                <p class="text-white/90 text-sm line-clamp-2 mb-4">
                                    {{ Str::limit($area->deskripsi, 80) }}
                                </p>
                                <div class="flex items-center text-white gap-2 font-medium">
                                    {{ __('site.explore') }}
                                    <svg class="w-5 h-5 transform transition-transform group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Events Timeline Section --}}
    <section class="bg-gray-50 events-section section-parallax section-reveal">
        <div class="parallax-bg pattern-grid" data-speed="0.1" style="opacity:.3"></div>
        <div class="container mx-auto px-6">
            <div class="text-center mb-8">
                <span class="text-blue-600 font-semibold uppercase tracking-wide text-sm">{{ __('site.event_calendar') }}</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-4 mb-3">
                    {{ __('site.event_calendar') }}
                </h2>
                <div class="section-divider"></div>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    {{ __('site.event_calendar_subtitle') }}
                </p>
            </div>

            <div class="max-w-6xl mx-auto relative">
                <button type="button" class="scroller-prev scroller-nav left-0 z-10 hidden md:block bg-white/90 hover:bg-white shadow-lg rounded-full p-2 border border-gray-200">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" class="scroller-next scroller-nav right-0 z-10 hidden md:block bg-white/90 hover:bg-white shadow-lg rounded-full p-2 border border-gray-200">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>

                @php
                    $months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                    $eventsByMonth = $events->groupBy('month');
                @endphp

                <div id="month-scroller" class="month-scroller no-scrollbar overflow-x-auto flex gap-4 px-1">
                    @foreach($months as $m)
                        @php $list = $eventsByMonth->get($m, collect()); @endphp
                        <div class="min-w-[280px] md:min-w-[320px] month-card bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden parallax-card">
                            <div class="px-5 py-4 flex items-center justify-between bg-gradient-to-r from-blue-50 to-purple-50 border-b border-gray-100">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white font-bold">{{ substr($m,0,1) }}</span>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $m }}</h3>
                                </div>
                                <span class="text-xs text-gray-500">{{ $list->count() }} acara</span>
                            </div>
                            <div class="p-4 space-y-3">
                                @forelse($list->take(3) as $event)
                                    @php $eventUrl = $event->url ?? $event->link ?? null; @endphp
                                    <a href="{{ $eventUrl ?: route('destinasi.index') }}" class="group block">
                                        <div class="flex gap-3">
                                            @if($event->image)
                                                <img src="{{ \App\Services\ImageUrl::url($event->image) }}" alt="{{ $event->judul }}" class="w-16 h-16 rounded-lg object-cover flex-shrink-0 parallax-target">
                                            @else
                                                <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 flex-shrink-0">📅</div>
                                            @endif
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                                                    <span class="inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>{{ $event->tanggal }}</span>
                                                    @if(!empty($event->lokasi))<span class="inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>{{ $event->lokasi }}</span>@endif
                                                </div>
                                                <div class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-blue-600">{{ $event->judul }}</div>
                                                <div class="text-xs text-gray-600 line-clamp-2">{{ $event->deskripsi }}</div>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-sm text-gray-500">Belum ada acara di bulan ini.</div>
                                @endforelse
                                @if($list->count() > 3)
                                    <a href="{{ route('events.index', ['month' => $m]) }}" class="text-blue-600 text-sm font-semibold inline-flex items-center gap-1">{{ __('site.view_all') }} <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action Section --}}
    {{-- Akomodasi & Transportasi Section --}}
    <section class="bg-white section-parallax section-reveal py-16">
        <div class="container mx-auto px-6">
            <div class="text-center mb-10">
                <h2 class="text-4xl font-black text-gray-900">{{ __('site.accommodation_transport') }}</h2>
                <p class="text-gray-600 mt-3">{{ __('site.accommodation_transport_subtitle') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Akomodasi Column --}}
                <div>
                    <div class="mb-6 flex items-center justify-between">
                        <h3 class="text-2xl font-semibold">{{ __('site.accommodation') }}</h3>
                        @if(Route::has('akomodasi.index'))
                            <a href="{{ route('akomodasi.index') }}" class="text-blue-600 text-sm font-medium">{{ __('site.view_all') }}</a>
                        @else
                            <a href="/akomodasi" class="text-blue-600 text-sm font-medium">{{ __('site.view_all') }}</a>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($akomodasiHome as $a)
                            @if(Route::has('akomodasi.show'))
                                <a href="{{ route('akomodasi.show', $a->slug) }}" class="group block rounded-xl overflow-hidden shadow-sm parallax-card bg-white">
                                <div class="flex items-start p-4 gap-4">
                                    <div class="w-16 h-16 rounded-lg bg-gray-100 flex-shrink-0 flex items-center justify-center text-blue-600 overflow-hidden">
                                        @if(!empty($a->thumbnail))
                                            <img src="{{ \App\Services\ImageUrl::url($a->thumbnail) }}" alt="{{ $a->nama }}" class="w-full h-full object-cover" loading="lazy">
                                        @else
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h3l2 3 3-6 3 6 2-3h3a1 1 0 001-1V7a1 1 0 00-1 1z"/></svg>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm text-gray-500 mb-2">{{ $a->tipe ?? '-' }}</div>
                                        <h4 class="font-bold text-gray-900 mb-1 group-hover:text-blue-600">{{ Str::limit($a->nama, 48) }}</h4>
                                        <p class="text-gray-600 text-sm line-clamp-2">{{ Str::limit($a->deskripsi, 80) }}</p>
                                    </div>
                                </div>
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Transportasi Column --}}
                <div>
                    <div class="mb-6 flex items-center justify-between">
                        <h3 class="text-2xl font-semibold">{{ __('site.transport') }}</h3>
                        @if(Route::has('transportasi.index'))
                            <a href="{{ route('transportasi.index') }}" class="text-blue-600 text-sm font-medium">{{ __('site.view_all') }}</a>
                        @else
                            <a href="/transportasi" class="text-blue-600 text-sm font-medium">{{ __('site.view_all') }}</a>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($transportasiHome as $t)
                            @if(Route::has('transportasi.show'))
                                <a href="{{ route('transportasi.show', $t->slug) }}" class="group block rounded-xl overflow-hidden shadow-sm parallax-card bg-white">
                                <div class="flex items-start p-4 gap-4">
                                    <div class="w-16 h-16 rounded-lg bg-gray-100 flex-shrink-0 flex items-center justify-center text-blue-600 overflow-hidden">
                                        @if(!empty($t->thumbnail))
                                            <img src="{{ \App\Services\ImageUrl::url($t->thumbnail) }}" alt="{{ $t->nama }}" class="w-full h-full object-cover" loading="lazy">
                                        @else
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 7h4l3-7h4"/></svg>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm text-gray-500 mb-2">{{ $t->tipe ?? '-' }}</div>
                                        <h4 class="font-bold text-gray-900 mb-1 group-hover:text-blue-600">{{ Str::limit($t->nama, 48) }}</h4>
                                        <p class="text-gray-600 text-sm line-clamp-2">{{ Str::limit($t->deskripsi, 80) }}</p>
                                    </div>
                                </div>
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @php
        use App\Services\ImageUrl;
        $ctaBackgroundUrl = ImageUrl::url($featuredDestinations->first()->foto->first()->url ?? null);
    @endphp
    <section class="parallax-section relative cta-section" {!! $ctaBackgroundUrl ? 'style="background-image: url(' . e($ctaBackgroundUrl) . ');"' : '' !!}>
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-purple-900/90"></div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <h2 class="text-4xl md:text-6xl font-black text-white mb-8 leading-tight">
                {{ __('site.cta_title') }}
            </h2>
            <p class="text-xl md:text-2xl text-white/90 mb-12 max-w-3xl mx-auto leading-relaxed">
                {{ __('site.cta_subtitle') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('destinasi.index') }}" class="btn-primary inline-flex items-center justify-center gap-2 px-10 py-5 rounded-xl text-white font-bold text-lg shadow-2xl">
                    {{ __('site.explore_destinations') }}
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="#" class="inline-flex items-center justify-center gap-2 px-10 py-5 rounded-xl bg-white text-blue-600 font-bold text-lg shadow-2xl hover:bg-gray-100 transition-all">
                    {{ __('site.download_guide') }}
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for scroll animations
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

    document.querySelectorAll('.slide-up, .section-reveal').forEach(element => {
        observer.observe(element);
    });

    // Enhanced parallax effect for all layers
    let ticking = false;
    let lastScrollY = window.pageYOffset;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const windowHeight = window.innerHeight;
        
        // Parallax for hero background and decorative layers
        document.querySelectorAll('.parallax-bg').forEach(layer => {
            const speed = parseFloat(layer.dataset.speed) || 0.4;
            const yPos = -(scrolled * speed);
            layer.style.transform = `translate3d(0, ${yPos}px, 0)`;
        });
        
        // Special handling for CTA parallax section with background
    const ctaSection = document.querySelector('.parallax-section.cta-section');
        if (ctaSection) {
            const rect = ctaSection.getBoundingClientRect();
            if (rect.top < windowHeight && rect.bottom > 0) {
                const scrollPercent = (windowHeight - rect.top) / (windowHeight + rect.height);
                const yPos = -(scrollPercent * 100);
                ctaSection.style.backgroundPositionY = `${yPos}px`;
            }
        }
        
        lastScrollY = scrolled;
        ticking = false;
    }
    
    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(updateParallax);
            ticking = true;
        }
    });
    
    // Trigger initial parallax
    updateParallax();
    
    // Add fade-in animation for month cards
    const eventObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
                eventObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    document.querySelectorAll('#month-scroller .month-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        eventObserver.observe(card);
    });

    // Horizontal scroller controls
    const scroller = document.getElementById('month-scroller');
    const prevBtn = document.querySelector('.scroller-prev');
    const nextBtn = document.querySelector('.scroller-next');
    if (scroller && prevBtn && nextBtn) {
        const step = 340; // card width + gap
        prevBtn.addEventListener('click', () => scroller.scrollBy({ left: -step, behavior: 'smooth' }));
        nextBtn.addEventListener('click', () => scroller.scrollBy({ left: step, behavior: 'smooth' }));
    }

    // Mouse parallax on cards (very subtle)
    const maxTilt = 6; // degrees
    document.querySelectorAll('.parallax-card').forEach(card => {
        const target = card.querySelector('.parallax-target') || card;
        if (!target) return;
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const rx = ((y / rect.height) - 0.5) * -maxTilt;
            const ry = ((x / rect.width) - 0.5) * maxTilt;
            target.style.transform = `perspective(800px) rotateX(${rx}deg) rotateY(${ry}deg) scale(1.02)`;
        });
        card.addEventListener('mouseleave', () => {
            target.style.transform = 'none';
        });
    });
});
</script>
@endpush
