@extends('layouts.admin')

@section('page-title', 'Edit Transportasi')

@section('content')
    <div class="max-w-2xl bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h1 class="text-xl font-semibold mb-4">Edit Transportasi</h1>
    <form method="POST" action="{{ route('panel.transportasi.update', $transportasi) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm">Nama</label>
                <input name="nama" value="{{ $transportasi->nama }}" class="mt-1 block w-full rounded border-gray-300" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Tipe</label>
                <input name="tipe" value="{{ $transportasi->tipe }}" class="mt-1 block w-full rounded border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-sm">Rute</label>
                <input name="rute" value="{{ $transportasi->rute }}" class="mt-1 block w-full rounded border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-sm">Deskripsi</label>
                <textarea name="deskripsi" class="mt-1 block w-full rounded border-gray-300" rows="4">{{ $transportasi->deskripsi }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*" class="mt-1 block w-full rounded border-gray-300">
                @if($transportasi->thumbnail)
                    <img src="{{ Storage::url($transportasi->thumbnail) }}" alt="Thumbnail" class="mt-2 w-32 h-32 object-cover rounded">
                @endif
                <p class="text-xs text-gray-500 mt-1">JPG/PNG hingga 4MB. Mengunggah gambar baru akan mengganti thumbnail.</p>
            </div>
            <div class="flex justify-end">
                <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Save</button>
            </div>
        </form>
    </div>
@endsection
