@extends('layouts.admin')

@section('page-title', 'Edit Akomodasi')

@section('content')
    <div class="max-w-2xl bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h1 class="text-xl font-semibold mb-4">Edit Akomodasi</h1>
    <form method="POST" action="{{ route('panel.akomodasi.update', $akomodasi) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm">Nama</label>
                <input name="nama" value="{{ $akomodasi->nama }}" class="mt-1 block w-full rounded border-gray-300" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Tipe</label>
                <input name="tipe" value="{{ $akomodasi->tipe }}" class="mt-1 block w-full rounded border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-sm">Lokasi</label>
                <input name="lokasi" value="{{ $akomodasi->lokasi }}" class="mt-1 block w-full rounded border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-sm">Deskripsi</label>
                <textarea name="deskripsi" class="mt-1 block w-full rounded border-gray-300" rows="4">{{ $akomodasi->deskripsi }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*" class="mt-1 block w-full rounded border-gray-300">
                @if($akomodasi->thumbnail)
                    <img src="{{ Storage::url($akomodasi->thumbnail) }}" alt="Thumbnail" class="mt-2 w-32 h-32 object-cover rounded">
                @endif
                <p class="text-xs text-gray-500 mt-1">JPG/PNG hingga 4MB. Mengunggah gambar baru akan mengganti thumbnail.</p>
            </div>
            <div class="flex justify-end">
                <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Save</button>
            </div>
        </form>
    </div>
@endsection
