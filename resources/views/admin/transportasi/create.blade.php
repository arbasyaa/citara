@extends('layouts.admin')

@section('page-title', 'New Transportasi')

@section('content')
    <div class="max-w-2xl bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h1 class="text-xl font-semibold mb-4">Tambah Transportasi</h1>
    <form method="POST" action="{{ route('panel.transportasi.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm">Nama</label>
                <input name="nama" class="mt-1 block w-full rounded border-gray-300" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Tipe</label>
                <input name="tipe" class="mt-1 block w-full rounded border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-sm">Rute</label>
                <input name="rute" class="mt-1 block w-full rounded border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-sm">Deskripsi</label>
                <textarea name="deskripsi" class="mt-1 block w-full rounded border-gray-300" rows="4"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*" class="mt-1 block w-full rounded border-gray-300">
                <p class="text-xs text-gray-500 mt-1">JPG/PNG hingga 4MB. Opsional.</p>
            </div>
            <div class="flex justify-end">
                <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Create</button>
            </div>
        </form>
    </div>
@endsection
