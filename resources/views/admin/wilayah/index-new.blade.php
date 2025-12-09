@extends('layouts.admin')

@section('page-title', 'Kelola Wilayah Wisata')

@section('breadcrumb')
    <span class="text-gray-900 font-medium">Wilayah Wisata</span>
@endsection

@section('content')
{{-- Header Actions --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Wilayah Wisata</h1>
        <p class="text-gray-600 mt-1">Kelola wilayah dan kawasan di Cilacap</p>
    </div>
    <a href="{{ route('panel.wilayah.create') }}" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold shadow-lg shadow-indigo-500/50 hover:shadow-xl hover:scale-105 transition-all flex items-center gap-2">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Wilayah Baru
    </a>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 admin-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total Wilayah</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Wilayah::count() }}</p>
            </div>
            <div class="h-12 w-12 rounded-lg bg-green-50 flex items-center justify-center">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 admin-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Dengan Destinasi</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Wilayah::has('destinasi')->count() }}</p>
            </div>
            <div class="h-12 w-12 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 admin-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Wilayah Kosong</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Wilayah::doesntHave('destinasi')->count() }}</p>
            </div>
            <div class="h-12 w-12 rounded-lg bg-yellow-50 flex items-center justify-center">
                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>
    </div>
</div>

{{-- Table Card --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Area Name</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Destinasi</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Translations</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse(\App\Models\Wilayah::withCount('destinasi')->get() as $wilayah)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($wilayah->nama, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $wilayah->nama }}</div>
                                    @if($wilayah->deskripsi)
                                        <div class="text-xs text-gray-500 line-clamp-1">{{ Str::limit($wilayah->deskripsi, 50) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <code class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">{{ $wilayah->slug }}</code>
                        </td>
                        <td class="px-6 py-4">
                            <span class="admin-badge admin-badge-blue">
                                {{ $wilayah->destinasi_count }} {{ Str::plural('destination', $wilayah->destinasi_count) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-1">
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded">🇮🇩 ID</span>
                                @if($wilayah->nama_en)
                                    <span class="px-2 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded">🇬🇧 EN</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-500 text-xs rounded">🇬🇧 —</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('panel.wilayah.edit', $wilayah) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('panel.wilayah.destroy', $wilayah) }}" onsubmit="return confirm('Hapus {{ $wilayah->nama }}? Semua destinasi di wilayah ini akan kehilangan asosiasi wilayahnya.')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum ada wilayah wisata</h3>
                                <p class="mt-2 text-sm text-gray-600">Mulai dengan membuat wilayah wisata pertama Anda.</p>
                                <a href="{{ route('panel.wilayah.create') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Add First Area
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
