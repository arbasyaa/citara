@extends('layouts.public')

@section('title', $transportasi->nama)

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
    
    .btn-action {
        background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        transition: all 0.3s ease;
    }
    
    .btn-action:hover {
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
    {{-- Professional Hero with Image --}}
    @if(!empty($transportasi->thumbnail))
        <section class="hero-detail relative">
            <div class="absolute inset-0">
                <img 
                    src="{{ \App\Services\ImageUrl::url($transportasi->thumbnail) }}"
                    alt="{{ $transportasi->nama }}"
                    class="w-full h-full object-cover"
                    loading="lazy"
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
                    <a href="{{ route('transportasi.index') }}" class="text-gray-600 hover:text-blue-600">{{ __('site.transport') }}</a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-900 font-medium">{{ $transportasi->nama }}</span>
                </nav>
            </div>
            
            {{-- Hero Content --}}
            <div class="absolute bottom-0 left-0 right-0 pb-12 z-10">
                <div class="container mx-auto px-6">
                    @if($transportasi->tipe)
                        <div class="inline-block px-4 py-2 bg-purple-600 text-white rounded-full mb-4 font-semibold">
                            {{ $transportasi->tipe }}
                        </div>
                    @endif
                    <h1 class="text-5xl md:text-7xl font-black text-white mb-4">
                        {{ $transportasi->nama }}
                    </h1>
                    @if($transportasi->rute)
                        <div class="flex items-center gap-6 text-white/90">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-lg">{{ Str::limit($transportasi->rute, 60) }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- Main Content --}}
    <section class="container mx-auto px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 items-start">
            {{-- Left Column: Description --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- About Section --}}
                <article class="content-card bg-white rounded-2xl shadow-xl p-8 md:p-12">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-black text-gray-900">{{ __('site.about_transport') }}</h2>
                    </div>
                    @if($transportasi->deskripsi)
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($transportasi->deskripsi)) !!}
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-sm">{{ __('site.description_not_available') }}</p>
                        </div>
                    @endif
                </article>
            </div>

            {{-- Right Column: Sidebar --}}
            <aside class="space-y-6 lg:sticky lg:top-24">
                {{-- Route & Details Card --}}
                <div class="content-card bg-white rounded-2xl shadow-xl p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ __('site.detail_information') }}</h3>
                    </div>
                    
                    <div class="space-y-4">
                        @if($transportasi->rute)
                            <div class="pb-4 border-b border-gray-100">
                                <p class="text-sm text-gray-500 mb-1">{{ __('site.route_travel') }}</p>
                                <p class="text-gray-900 font-medium leading-relaxed">{{ $transportasi->rute }}</p>
                            </div>
                        @endif

                        @if($transportasi->tipe)
                            <div class="pb-4 border-b border-gray-100">
                                <p class="text-sm text-gray-500 mb-1">{{ __('site.transport_type') }}</p>
                                <p class="text-gray-900 font-medium">{{ $transportasi->tipe }}</p>
                            </div>
                        @endif

                        @if(!$transportasi->rute && !$transportasi->tipe)
                            <div class="text-center py-6 text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-sm">{{ __('site.detail_info_not_available') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
