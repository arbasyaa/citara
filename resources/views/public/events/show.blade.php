@extends('layouts.public')

@section('title', $event->title ?? $event->judul)

@push('styles')
<style>
    .hero-detail {
        height: 60vh;
        min-height: 400px;
        position: relative;
        overflow: hidden;
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
    
    .content-card {
        transition: all 0.3s ease;
        border-radius: 16px;
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .category-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: capitalize;
    }
    
    .category-festival {
        background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
        color: #92400E;
    }
    
    .category-workshop {
        background: linear-gradient(135deg, #DBEAFE 0%, #BFDBFE 100%);
        color: #1E40AF;
    }
    
    .category-pameran {
        background: linear-gradient(135deg, #E9D5FF 0%, #D8B4FE 100%);
        color: #6B21A8;
    }
    
    .info-item {
        display: flex;
        align-items: start;
        gap: 1rem;
        padding: 1rem;
        background: #F9FAFB;
        border-radius: 12px;
    }
    
    .info-item svg {
        flex-shrink: 0;
        width: 1.5rem;
        height: 1.5rem;
        color: #3B82F6;
    }
</style>
@endpush

@section('content')
    {{-- Hero Section --}}
    <section class="hero-detail relative">
        <div class="absolute inset-0">
            @if($event->image)
                <img 
                    src="{{ \App\Services\ImageUrl::url($event->image) }}"
                    alt="{{ $event->title ?? $event->judul }}"
                    class="w-full h-full object-cover"
                    loading="eager"
                >
            @else
                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                    <svg class="w-32 h-32 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
        
        {{-- Breadcrumb & Title --}}
        <div class="container mx-auto px-6 pt-32 relative z-10">
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-white/80">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">{{ __('site.home') }}</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('events.calendar') }}" class="hover:text-white transition">{{ __('site.event_calendar') }}</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-white font-semibold">{{ $event->title ?? $event->judul }}</li>
                </ol>
            </nav>
            
            <div class="mb-8">
                <div class="mb-4">
                    <span class="category-badge category-{{ $event->category ?? 'festival' }}">
                        {{ ucfirst($event->category ?? 'festival') }}
                    </span>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-white mb-4">
                    {{ $event->title ?? $event->judul }}
                </h1>
            </div>
        </div>
    </section>

    {{-- Content Section --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Description --}}
                    <div class="content-card p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('site.about_event') }}</h2>
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {{ $event->description ?? $event->deskripsi ?? __('site.no_description_available') }}
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Event Info --}}
                    <div class="content-card p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('site.event_info') }}</h3>
                        <div class="space-y-3">
                            {{-- Date --}}
                            @if($event->date_range ?? $event->tanggal)
                            <div class="info-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <div class="text-xs text-gray-500 mb-1">{{ __('site.date') }}</div>
                                    <div class="font-semibold text-gray-900">{{ $event->date_range ?? $event->tanggal }}</div>
                                </div>
                            </div>
                            @endif
                            
                            {{-- Location --}}
                            @if($event->location ?? $event->lokasi)
                            <div class="info-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div>
                                    <div class="text-xs text-gray-500 mb-1">{{ __('site.location') }}</div>
                                    <div class="font-semibold text-gray-900">
                                        @if($event->destinasi)
                                            <a href="{{ route('destinasi.show', $event->destinasi->slug) }}" class="text-blue-600 hover:text-blue-700">
                                                {{ $event->destinasi->nama }}
                                            </a>
                                        @else
                                            {{ $event->location ?? $event->lokasi }}
                                        @endif
                                    </div>
                                    @if($event->destinasi && $event->destinasi->alamat_lokasi)
                                        <div class="text-sm text-gray-600 mt-1">{{ $event->destinasi->alamat_lokasi }}</div>
                                    @endif
                                </div>
                            </div>
                            @endif
                            
                            {{-- Month --}}
                            @if($event->month)
                            <div class="info-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <div class="text-xs text-gray-500 mb-1">{{ __('site.month') }}</div>
                                    <div class="font-semibold text-gray-900">{{ $event->month }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Back Button --}}
                    <a href="{{ route('events.calendar') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                        ← {{ __('site.back_to_calendar') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
