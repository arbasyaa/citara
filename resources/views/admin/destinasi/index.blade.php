@extends('layouts.admin')

@section('page-title', 'Destinasi')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-wrap gap-3 justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Daftar Destinasi</h2>
            <a href="{{ route('panel.destinasi.create') }}" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                Tambah Destinasi
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wilayah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($destinasi as $d)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $d->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $d->wilayah->nama ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $d->slug }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('panel.destinasi.edit', $d) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                            <form action="{{ route('panel.destinasi.destroy', $d) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 ml-4" onclick="return confirm('Hapus destinasi?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $destinasi->links() }}
        </div>
    </div>
@endsection
