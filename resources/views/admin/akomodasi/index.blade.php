@extends('layouts.admin')

@section('page-title', 'Akomodasi')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-wrap gap-3 justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Daftar Akomodasi</h2>
            <a href="{{ route('panel.akomodasi.create') }}" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                Tambah Akomodasi
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($akomodasi as $a)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $a->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $a->tipe }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $a->lokasi }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('panel.akomodasi.edit', $a) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                            <form action="{{ route('panel.akomodasi.destroy', $a) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 ml-4" onclick="return confirm('Hapus akomodasi?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $akomodasi->links() }}
        </div>
    </div>
@endsection
