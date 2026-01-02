@extends('layouts.admin')

@section('page-title', 'Kegiatan Kalender')

@section('breadcrumb')
    <span class="text-gray-900 font-medium">Kegiatan Kalender</span>
@endsection

@section('content')
{{-- Header Actions --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kegiatan Kalender</h1>
        <p class="text-gray-600 mt-1">Kelola aktivitas dan kegiatan mendatang</p>
    </div>
    <a href="{{ route('panel.events.create') }}" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold shadow-lg shadow-indigo-500/50 hover:shadow-xl hover:scale-105 transition-all flex items-center gap-2">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Kegiatan Baru
    </a>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 admin-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total Kegiatan</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\CalendarEvent::count() }}</p>
            </div>
            <div class="h-12 w-12 rounded-lg bg-purple-50 flex items-center justify-center">
                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 admin-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Mendatang</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\CalendarEvent::whereNotNull('start_date')->where('start_date', '>=', now())->count() }}</p>
            </div>
            <div class="h-12 w-12 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 admin-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Bulan Ini</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\CalendarEvent::whereNotNull('start_date')->whereMonth('start_date', now()->month)->count() }}</p>
            </div>
            <div class="h-12 w-12 rounded-lg bg-green-50 flex items-center justify-center">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 admin-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Kegiatan Lalu</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\CalendarEvent::whereNotNull('start_date')->where('start_date', '<', now())->count() }}</p>
            </div>
            <div class="h-12 w-12 rounded-lg bg-gray-50 flex items-center justify-center">
                <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>
</div>

{{-- Filter Bar --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6 admin-card">
    <form method="GET" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Cari kegiatan..." 
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
            >
        </div>
        <select name="month" class="px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">
            <option value="">Semua Bulan</option>
            @for($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                </option>
            @endfor
        </select>
        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-colors flex items-center gap-2">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Filter
        </button>
        @if(request()->hasAny(['search', 'month']))
            <a href="{{ route('panel.events.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                Bersihkan
            </a>
        @endif
    </form>
</div>

{{-- Events List --}}
<div class="space-y-4">
    @php
        $query = \App\Models\CalendarEvent::query();
        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }
        if (request('month')) {
            $query->whereMonth('start_date', request('month'));
        }
        $events = $query->orderBy('start_date', 'desc')->paginate(10);
    @endphp
    
    @forelse($events as $event)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 admin-card hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-start gap-6">
                    {{-- Date Badge --}}
                    @if($event->start_date)
                    <div class="flex-shrink-0 w-20 h-20 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex flex-col items-center justify-center text-white shadow-lg">
                        <span class="text-sm font-bold uppercase">{{ \Carbon\Carbon::parse($event->start_date)->format('M') }}</span>
                        <span class="text-2xl font-bold leading-none">{{ \Carbon\Carbon::parse($event->start_date)->format('d') }}</span>
                        <span class="text-xs opacity-80">{{ \Carbon\Carbon::parse($event->start_date)->format('Y') }}</span>
                    </div>
                    @endif

                    {{-- Event Image --}}
                    @if($event->image)
                        <img 
                            src="{{ \App\Services\ImageUrl::url($event->image) }}" 
                            alt="{{ $event->title }}" 
                            class="w-32 h-20 object-cover rounded-lg flex-shrink-0"
                        >
                    @endif

                    {{-- Event Details --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $event->title }}</h3>
                                @if($event->start_date)
                                    <p class="text-sm text-gray-600 mb-2">{{ \Carbon\Carbon::parse($event->start_date)->format('l, F d, Y') }}</p>
                                @endif
                                @if($event->location)
                                    <p class="text-sm text-gray-600 flex items-center gap-1">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $event->location }}
                                    </p>
                                @endif
                                @if($event->description)
                                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $event->description }}</p>
                                @endif
                                
                                {{-- Translation Status --}}
                                <div class="flex gap-2 mt-3">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded">🇮🇩 ID</span>
                                    @if($event->title_en)
                                        <span class="px-2 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded">🇬🇧 EN</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-500 text-xs rounded">🇬🇧 —</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <a href="{{ route('panel.events.edit', $event) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('panel.events.destroy', $event) }}" onsubmit="return confirm('Hapus kegiatan: {{ $event->title }}?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 admin-card">
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Kegiatan tidak ditemukan</h3>
                <p class="mt-2 text-sm text-gray-600">Mulai dengan membuat kegiatan kalender pertama Anda.</p>
                <a href="{{ route('panel.events.create') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Kegiatan Pertama
                </a>
            </div>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($events->hasPages())
    <div class="mt-6">
        {{ $events->links() }}
    </div>
@endif
@endsection
