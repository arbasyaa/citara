@extends('layouts.admin')

@section('page-title', 'Destinasi Baru')

@section('content')
    <div class="max-w-2xl bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h1 class="text-xl font-semibold mb-4">Tambah Destinasi</h1>
    <form method="POST" action="{{ route('panel.destinasi.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm">Nama</label>
                <input name="nama" class="mt-1 block w-full rounded border-gray-300" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Tipe</label>
                <select name="tipe" class="mt-1 block w-full rounded border-gray-300" required>
                    <option value="wisata">Wisata</option>
                    <option value="kuliner">Kuliner</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Wilayah</label>
                <select name="id_wilayah" class="mt-1 block w-full rounded border-gray-300">
                    <option value="">-- Pilih Wilayah --</option>
                    @foreach(App\Models\Wilayah::all() as $w)
                        <option value="{{ $w->id }}">{{ $w->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Deskripsi</label>
                <textarea name="deskripsi" class="mt-1 block w-full rounded border-gray-300" rows="4"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Alamat Lokasi (opsional)</label>
                <input name="alamat_lokasi" class="mt-1 block w-full rounded border-gray-300" placeholder="Alamat / deskripsi lokasi">
            </div>
            <div class="mb-4">
                <label class="block text-sm">Google Maps URL (opsional)</label>
                <input name="url_gmaps" class="mt-1 block w-full rounded border-gray-300" placeholder="https://maps.google.com/...">
            </div>
            <div class="mb-4 flex gap-6 items-center">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_highlight" value="1" class="form-checkbox">
                    <span class="ml-2 text-sm">Tandai sebagai Unggulan & Populer</span>
                </label>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Gambar</label>
                <input type="file" name="image" accept="image/*" class="mt-1 block w-full">
            </div>
            <div class="flex justify-end">
                <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Buat</button>
            </div>
        </form>
    </div>
@endsection
