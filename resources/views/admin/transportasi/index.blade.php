@extends('layouts.admin')

@section('page-title', 'Transportasi')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-wrap gap-3 justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Daftar Transportasi</h2>
            <div class="flex items-center gap-3">
                <form method="GET" action="" class="flex items-center gap-2">
                    <input name="q" value="{{ $q ?? '' }}" placeholder="Search..." class="px-3 py-2 rounded border border-gray-200">
                    <select name="per_page" class="px-2 py-2 rounded border border-gray-200">
                        <option>10</option>
                        <option selected>15</option>
                        <option>30</option>
                        <option>50</option>
                    </select>
                    <button class="px-3 py-2 bg-gray-800 text-white rounded">Search</button>
                </form>
                <a href="{{ route('panel.transportasi.create') }}" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                Tambah Transportasi
            </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rute</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($transportasi as $t)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $t->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $t->tipe }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $t->rute }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('panel.transportasi.edit', $t) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                            <form action="{{ route('panel.transportasi.destroy', $t) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 ml-4" onclick="return confirm('Hapus transportasi?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <p class="text-sm text-gray-600">Showing {{ $transportasi->firstItem() }} to {{ $transportasi->lastItem() }} of {{ $transportasi->total() }} results</p>
                <div class="flex justify-center sm:justify-end">
                    @include('components.admin-pagination', ['paginator' => $transportasi])
                </div>
            </div>
        </div>
    </div>
@endsection
