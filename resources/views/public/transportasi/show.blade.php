@extends('layouts.public')

@section('title', $transportasi->nama)

@push('styles')
<style>
    .content-card {
        transition: all 0.3s ease;
    }
    .content-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
    {{-- Breadcrumb --}}
    <section class="container mx-auto px-6 pt-8 pb-4">
        <nav class="flex items-center gap-2 text-sm">
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
    </section>

    {{-- Main Content --}}
    <section class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Content Area --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Hero Image --}}
                @if(!empty($transportasi->thumbnail))
                    <div class="content-card bg-white rounded-2xl shadow-xl overflow-hidden">
                        <img src="{{ \App\Services\ImageUrl::url($transportasi->thumbnail) }}" 
                             alt="{{ $transportasi->nama }}" 
                             class="w-full h-64 md:h-96 object-cover" 
                             loading="lazy">
                    </div>
                @endif

                {{-- Main Info --}}
                <article class="content-card bg-white rounded-2xl shadow-xl p-8 md:p-10">
                    <div class="mb-6">
                        @if($transportasi->tipe)
                            <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-4">
                                {{ $transportasi->tipe }}
                            </span>
                        @endif
                        <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-2">{{ $transportasi->nama }}</h1>
                    </div>

                    @if($transportasi->deskripsi)
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Deskripsi</h2>
                        </div>
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($transportasi->deskripsi)) !!}
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
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                {{-- Details Card --}}
                <div class="content-card bg-white rounded-2xl shadow-xl p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Detail Informasi</h3>
                    </div>

                    <div class="space-y-4">
                        @if($transportasi->rute)
                            <div class="pb-4 border-b border-gray-100">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <div>
                                        <div class="text-sm text-gray-500 mb-1">Rute</div>
                                        <div class="text-gray-900 font-medium">{{ $transportasi->rute }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($transportasi->tipe)
                            <div class="pb-4 border-b border-gray-100">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <div>
                                        <div class="text-sm text-gray-500 mb-1">Tipe</div>
                                        <div class="text-gray-900 font-medium">{{ $transportasi->tipe }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(!$transportasi->rute && !$transportasi->tipe)
                            <div class="text-center py-6 text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-sm">Detail informasi belum tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
