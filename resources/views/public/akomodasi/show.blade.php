@extends('layouts.public')

@section('title', $akomodasi->nama)

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
            <a href="{{ route('akomodasi.index') }}" class="text-gray-600 hover:text-blue-600">{{ __('site.accommodation') }}</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 font-medium">{{ $akomodasi->nama }}</span>
        </nav>
    </section>

    {{-- Main Content --}}
    <section class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Content Area --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Hero Image --}}
                @if(!empty($akomodasi->thumbnail))
                    <div class="content-card bg-white rounded-2xl shadow-xl overflow-hidden">
                        <img src="{{ \App\Services\ImageUrl::url($akomodasi->thumbnail) }}" 
                             alt="{{ $akomodasi->nama }}" 
                             class="w-full h-64 md:h-96 object-cover" 
                             loading="lazy">
                    </div>
                @endif

                {{-- Main Info --}}
                <article class="content-card bg-white rounded-2xl shadow-xl p-8 md:p-10">
                    <div class="mb-6">
                        @if($akomodasi->tipe)
                            <span class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold mb-4">
                                {{ $akomodasi->tipe }}
                            </span>
                        @endif
                        <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-2">{{ $akomodasi->nama }}</h1>
                    </div>

                    @if($akomodasi->deskripsi)
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Deskripsi</h2>
                        </div>
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($akomodasi->deskripsi)) !!}
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
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Detail Informasi</h3>
                    </div>

                    <div class="space-y-4">
                        @if($akomodasi->lokasi)
                            <div class="pb-4 border-b border-gray-100">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <div>
                                        <div class="text-sm text-gray-500 mb-1">Lokasi</div>
                                        <div class="text-gray-900 font-medium">{{ $akomodasi->lokasi }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($akomodasi->nomor_telepon)
                            <div class="pb-4 border-b border-gray-100">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <div>
                                        <div class="text-sm text-gray-500 mb-1">Telepon</div>
                                        <a href="tel:{{ $akomodasi->nomor_telepon }}" class="text-blue-600 hover:text-blue-700 font-medium">{{ $akomodasi->nomor_telepon }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($akomodasi->url_situs_web)
                            <div class="pb-4 border-b border-gray-100">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    <div>
                                        <div class="text-sm text-gray-500 mb-1">Website</div>
                                        <a href="{{ $akomodasi->url_situs_web }}" target="_blank" rel="noopener" class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center gap-1">
                                            Kunjungi Website
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($akomodasi->tipe)
                            <div class="pb-4 border-b border-gray-100">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <div>
                                        <div class="text-sm text-gray-500 mb-1">Tipe</div>
                                        <div class="text-gray-900 font-medium">{{ $akomodasi->tipe }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(!$akomodasi->lokasi && !$akomodasi->nomor_telepon && !$akomodasi->url_situs_web && !$akomodasi->tipe)
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
