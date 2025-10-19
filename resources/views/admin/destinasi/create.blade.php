@extends('layouts.admin')

@section('page-title', 'New Destinasi')

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
                <textarea name="deskripsi" class="mt-1 block w-full rounded border-gray-300"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Gambar</label>
                <input type="file" name="image" accept="image/*" class="mt-1 block w-full">
            </div>
            <div class="flex justify-end">
                <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Create</button>
            </div>
        </form>
    </div>
@endsection
