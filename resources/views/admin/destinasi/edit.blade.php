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
                <textarea name="deskripsi" class="mt-1 block w-full rounded border-gray-300" rows="4">{{ $destinasi->deskripsi }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Alamat Lokasi (opsional)</label>
                <input name="alamat_lokasi" value="{{ $destinasi->alamat_lokasi }}" class="mt-1 block w-full rounded border-gray-300" placeholder="Alamat / deskripsi lokasi">
            </div>
            <div class="mb-4">
                <label class="block text-sm">Google Maps URL (opsional)</label>
                <input name="url_gmaps" value="{{ $destinasi->url_gmaps }}" class="mt-1 block w-full rounded border-gray-300" placeholder="https://maps.google.com/...">
            </div>
            <div class="mb-4 flex gap-6 items-center">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_highlight" value="1" class="form-checkbox" {{ ($destinasi->is_popular || $destinasi->is_featured) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm">Tandai sebagai Unggulan & Populer</span>
                </label>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Gambar</label>
                <input type="file" name="image" accept="image/*" class="mt-1 block w-full">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Save</button>
            </div>
        </form>

        @if($destinasi->foto && $destinasi->foto->count())
            <div class="mt-6 pt-6 border-t border-gray-200">
                <label class="block text-sm font-medium mb-3">Foto yang Sudah Diunggah</label>
                <div class="grid grid-cols-3 gap-2">
                    @foreach($destinasi->foto as $foto)
                        <div class="relative group">
                            <img src="{{ \App\Services\ImageUrl::url($foto->url) }}" class="max-h-40 w-full object-cover rounded">
                            <form method="POST" action="{{ route('panel.destinasi.photo.destroy', [$destinasi, $foto]) }}" class="absolute top-1 right-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus foto ini? Destinasi tidak akan terhapus.')" class="bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full p-1.5 text-rose-600 hover:text-rose-800 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
