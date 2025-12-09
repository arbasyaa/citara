@extends('layouts.admin')

@section('page-title', 'Dasbor')

@section('breadcrumb')
    <span class="text-gray-900 font-medium">Dasbor</span>
@endsection

@section('content')
{{-- Welcome Banner --}}
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Selamat datang kembali, Admin! 👋</h1>
            <p class="text-indigo-100">Berikut perkembangan platform Pariwisata Cilacap hari ini.</p>
        </div>
        <div class="hidden md:block">
            <svg class="w-32 h-32 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/></svg>
        </div>
    </div>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- Total Destinasi --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 admin-card">
        <div class="flex items-center justify-between mb-4">
            <div class="h-12 w-12 rounded-xl bg-blue-50 flex items-center justify-center">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-md">Destinasi</span>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ \App\Models\Destinasi::count() }}</h3>
        <p class="text-sm text-gray-600">Total lokasi</p>
        <div class="mt-4 flex gap-2 text-xs">
            <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded">🏖️ {{ \App\Models\Destinasi::where('tipe', 'wisata')->count() }} Wisata</span>
            <span class="px-2 py-1 bg-orange-50 text-orange-700 rounded">🍜 {{ \App\Models\Destinasi::where('tipe', 'kuliner')->count() }} Kuliner</span>
        </div>
    </div>

    {{-- Wilayah Wisata --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 admin-card">
        <div class="flex items-center justify-between mb-4">
            <div class="h-12 w-12 rounded-xl bg-green-50 flex items-center justify-center">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="px-2 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-md">Wilayah</span>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ \App\Models\Wilayah::count() }}</h3>
        <p class="text-sm text-gray-600">Wilayah wisata</p>
        <a href="{{ route('panel.wilayah.index') }}" class="mt-4 inline-flex items-center text-xs text-green-600 hover:text-green-700 font-semibold">
            Kelola Wilayah 
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    {{-- Events --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 admin-card">
        <div class="flex items-center justify-between mb-4">
            <div class="h-12 w-12 rounded-xl bg-purple-50 flex items-center justify-center">
                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <span class="px-2 py-1 bg-purple-50 text-purple-700 text-xs font-semibold rounded-md">Kegiatan</span>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ \App\Models\CalendarEvent::count() }}</h3>
        <p class="text-sm text-gray-600">Kegiatan kalender</p>
        <a href="{{ route('panel.events.index') }}" class="mt-4 inline-flex items-center text-xs text-purple-600 hover:text-purple-700 font-semibold">
            Lihat Kalender
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    {{-- Services --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 admin-card">
        <div class="flex items-center justify-between mb-4">
            <div class="h-12 w-12 rounded-xl bg-indigo-50 flex items-center justify-center">
                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <span class="px-2 py-1 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-md">Layanan</span>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ \App\Models\Akomodasi::count() + \App\Models\Transportasi::count() }}</h3>
        <p class="text-sm text-gray-600">Akomodasi & Transportasi</p>
        <div class="mt-4 flex gap-2 text-xs">
            <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded">🏨 {{ \App\Models\Akomodasi::count() }}</span>
            <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded">🚗 {{ \App\Models\Transportasi::count() }}</span>
        </div>
    </div>
</div>

{{-- Content Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Destinasi Terbaru --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 admin-card">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Destinasi Terbaru</h2>
                <p class="text-sm text-gray-600 mt-1">Lokasi terbaru yang ditambahkan</p>
            </div>
            <a href="{{ route('panel.destinasi.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-semibold">Lihat Semua</a>
        </div>
        <div class="p-6">
            @php
                $recentDestinations = \App\Models\Destinasi::latest()->take(5)->get();
            @endphp
            
            @if($recentDestinations->count())
                <div class="space-y-3">
                    @foreach($recentDestinations as $dest)
                        <div class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            @if($dest->foto->count())
                                <img src="{{ \App\Services\ImageUrl::url($dest->foto->first()->url) }}" alt="{{ $dest->nama }}" class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 truncate">{{ $dest->nama }}</h3>
                                <p class="text-xs text-gray-500">{{ $dest->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="admin-badge {{ $dest->tipe === 'wisata' ? 'admin-badge-blue' : 'admin-badge-orange' }}">
                                {{ $dest->tipe === 'wisata' ? '🏖️ Wisata' : '🍜 Kuliner' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">No destinations yet</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Kegiatan Mendatang --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 admin-card">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Kegiatan Mendatang</h2>
                <p class="text-sm text-gray-600 mt-1">Aktivitas yang dijadwalkan berikutnya</p>
            </div>
            <a href="{{ route('panel.events.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-semibold">Lihat Semua</a>
        </div>
        <div class="p-6">
            @php
                $upcomingEvents = \App\Models\CalendarEvent::whereNotNull('start_date')->where('start_date', '>=', now())->orderBy('start_date')->take(5)->get();
            @endphp
            
            @if($upcomingEvents->count())
                <div class="space-y-3">
                    @foreach($upcomingEvents as $event)
                        <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex flex-col items-center justify-center text-white">
                                <span class="text-xs font-bold">{{ \Carbon\Carbon::parse($event->start_date)->format('M') }}</span>
                                <span class="text-lg font-bold leading-none">{{ \Carbon\Carbon::parse($event->start_date)->format('d') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 truncate">{{ $event->title }}</h3>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($event->start_date)->format('l, M d, Y') }}</p>
                                @if($event->location)
                                    <p class="text-xs text-gray-500 mt-1">📍 {{ $event->location }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">Belum ada kegiatan mendatang</p>
                    <a href="{{ route('panel.events.create') }}" class="mt-4 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-700 font-semibold">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Kegiatan
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Aksi Cepat --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 admin-card">
    <div class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-900">Aksi Cepat</h2>
        <p class="text-sm text-gray-600 mt-1">Tugas umum dan pintasan</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('panel.destinasi.create') }}" class="flex flex-col items-center p-6 rounded-lg border-2 border-dashed border-gray-300 hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                <div class="h-12 w-12 rounded-xl bg-indigo-100 group-hover:bg-indigo-600 flex items-center justify-center mb-3 transition-colors">
                    <svg class="h-6 w-6 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <span class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">Tambah Destinasi</span>
            </a>

            <a href="{{ route('panel.events.create') }}" class="flex flex-col items-center p-6 rounded-lg border-2 border-dashed border-gray-300 hover:border-purple-500 hover:bg-purple-50 transition-all group">
                <div class="h-12 w-12 rounded-xl bg-purple-100 group-hover:bg-purple-600 flex items-center justify-center mb-3 transition-colors">
                    <svg class="h-6 w-6 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-sm font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">Buat Kegiatan</span>
            </a>

            <a href="{{ route('panel.wilayah.create') }}" class="flex flex-col items-center p-6 rounded-lg border-2 border-dashed border-gray-300 hover:border-green-500 hover:bg-green-50 transition-all group">
                <div class="h-12 w-12 rounded-xl bg-green-100 group-hover:bg-green-600 flex items-center justify-center mb-3 transition-colors">
                    <svg class="h-6 w-6 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-sm font-semibold text-gray-900 group-hover:text-green-600 transition-colors">Tambah Wilayah</span>
            </a>

            <a href="{{ route('home') }}" target="_blank" class="flex flex-col items-center p-6 rounded-lg border-2 border-dashed border-gray-300 hover:border-blue-500 hover:bg-blue-50 transition-all group">
                <div class="h-12 w-12 rounded-xl bg-blue-100 group-hover:bg-blue-600 flex items-center justify-center mb-3 transition-colors">
                    <svg class="h-6 w-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <span class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">Lihat Website</span>
            </a>
        </div>
    </div>
</div>
@endsection
