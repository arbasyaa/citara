@extends('layouts.admin')

@section('page-title', 'Wilayah')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-wrap gap-3 justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Daftar Wilayah</h2>
            <a href="{{ route('panel.wilayah.create') }}" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                Tambah Wilayah
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Destinasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($wilayah as $w)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $w->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $w->slug }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $w->destinasi_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('panel.wilayah.edit', $w) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="{{ route('panel.wilayah.destroy', $w) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 ml-4" onclick="return confirm('Apakah Anda yakin?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $wilayah->links() }}
        </div>
    </div>
@endsection