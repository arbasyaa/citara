@extends('layouts.admin')

@section('page-title', 'Edit Destinasi')

@section('content')
    <div class="max-w-2xl bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h1 class="text-xl font-semibold mb-4">Edit Destinasi</h1>
    <form method="POST" action="{{ route('panel.destinasi.update', $destinasi) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm">Nama</label>
                <input name="nama" value="{{ $destinasi->nama }}" class="mt-1 block w-full rounded border-gray-300" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Wilayah</label>
                <select name="id_wilayah" class="mt-1 block w-full rounded border-gray-300">
                    <option value="">-- Pilih Wilayah --</option>
                    @foreach(App\Models\Wilayah::all() as $w)
                        <option value="{{ $w->id }}" {{ $destinasi->id_wilayah == $w->id ? 'selected' : '' }}>{{ $w->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Deskripsi</label>
                <textarea name="deskripsi" class="mt-1 block w-full rounded border-gray-300">{{ $destinasi->deskripsi }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Gambar</label>
                <input type="file" name="image" accept="image/*" class="mt-1 block w-full">
                @if($destinasi->foto && $destinasi->foto->count())
                    <div class="mt-2 grid grid-cols-3 gap-2">
                        @foreach($destinasi->foto as $foto)
                            <div>
                                <img src="{{ asset('storage/' . $foto->url) }}" class="max-h-40 rounded">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="flex justify-end">
                <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Save</button>
            </div>
        </form>
    </div>
@endsection
