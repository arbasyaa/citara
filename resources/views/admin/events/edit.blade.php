@extends('layouts.admin')

@section('page-title', 'Edit Kegiatan')

@section('content')
        <div class="max-w-2xl bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h1 class="text-xl font-bold mb-4">Edit Kegiatan</h1>
            <form method="POST" action="{{ route('panel.events.update', $event) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm">Bulan</label>
                    <select name="month" class="mt-1 block w-full rounded border-gray-300" required>
                        @php
                            $monthNames = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                            $currentMonth = old('month', $event->month);
                            // Convert Indonesian month name to number if needed
                            if (!is_numeric($currentMonth)) {
                                $currentMonth = array_search($currentMonth, $monthNames) ?: $currentMonth;
                            }
                        @endphp
                        @for($m=1;$m<=12;$m++)
                            <option value="{{ $m }}" {{ (string) $currentMonth === (string) $m ? 'selected' : '' }}>{{ $monthNames[$m] }}</option>
                        @endfor
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Kategori</label>
                    <select name="category" class="mt-1 block w-full rounded border-gray-300" required>
                        <option value="">Pilih kategori</option>
                        <option value="festival" {{ old('category', $event->category) === 'festival' ? 'selected' : '' }}>Festival & Acara</option>
                        <option value="workshop" {{ old('category', $event->category) === 'workshop' ? 'selected' : '' }}>Workshop & Kelas</option>
                        <option value="pameran" {{ old('category', $event->category) === 'pameran' ? 'selected' : '' }}>Pameran & Bazar</option>
                    </select>
                </div>
                <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm">Tahun</label>
                        <input name="year" value="{{ old('year', $event->year) }}" class="mt-1 block w-full rounded border-gray-300" placeholder="contoh: 2026">
                    </div>
                    <div>
                        <label class="block text-sm">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ old('start_date', optional($event->start_date)->format('Y-m-d')) }}" class="mt-1 block w-full rounded border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm">Tanggal Selesai</label>
                        <input type="date" name="end_date" value="{{ old('end_date', optional($event->end_date)->format('Y-m-d')) }}" class="mt-1 block w-full rounded border-gray-300">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Rentang Tanggal</label>
                    <input name="date_range" value="{{ $event->date_range }}" class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Judul</label>
                    <input name="title" value="{{ $event->title }}" class="mt-1 block w-full rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Lokasi</label>
                    <div class="relative">
                        <input name="location" id="locationInput" value="{{ old('location', $event->location) }}" class="mt-1 block w-full rounded border-gray-300" placeholder="Cari destinasi (contoh: Teluk Penyu)" required>
                        <div id="locationDropdown" class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded shadow hidden max-h-56 overflow-auto"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Ketik untuk mencari destinasi, lalu pilih dari daftar untuk mengisi lokasi.</p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Deskripsi</label>
                    <textarea name="description" class="mt-1 block w-full rounded border-gray-300">{{ $event->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Gambar</label>
                    <input type="file" name="image" id="eventImage" accept="image/*" class="mt-1 block w-full">
                    @if($event->image)
                        <div class="mt-2">
                            <img src="{{ \App\Services\ImageUrl::url($event->image) }}" alt="current" class="max-h-40 rounded">
                        </div>
                    @endif
                    <img id="eventImagePreview" src="" alt="" class="mt-3 max-h-40 hidden rounded">
                </div>
                <div class="flex justify-end">
                    <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
        </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const input = document.getElementById('eventImage');
    const preview = document.getElementById('eventImagePreview');
    if (input) {
        input.addEventListener('change', function(e){
            const file = e.target.files && e.target.files[0];
            if (!file) { preview.src = ''; preview.classList.add('hidden'); return; }
            const url = URL.createObjectURL(file);
            preview.src = url; preview.classList.remove('hidden');
        });
    }

    const locationInput = document.getElementById('locationInput');
    const dd = document.getElementById('locationDropdown');

    if (locationInput && dd) {
        let debounceId;
        const renderItems = (items) => {
            dd.innerHTML = '';
            if (!items || items.length === 0) {
                dd.classList.add('hidden');
                return;
            }
            items.forEach(item => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'w-full text-left px-3 py-2 hover:bg-gray-50';
                btn.dataset.name = item.nama;
                btn.dataset.location = item.alamat_lokasi || item.nama;
                btn.innerHTML = `${item.nama}${item.alamat_lokasi ? `<span class="block text-xs text-gray-500">${item.alamat_lokasi}</span>` : ''}`;
                btn.addEventListener('click', () => {
                    const autoLocation = btn.dataset.location || btn.dataset.name;
                    locationInput.value = autoLocation;
                    locationInput.dataset.autofilled = '1';
                    dd.classList.add('hidden');
                });
                dd.appendChild(btn);
            });
            dd.classList.remove('hidden');
        };

        const fetchItems = async (q) => {
            try {
                const url = new URL(window.location.origin + '/panel/destinasi/search');
                if (q) url.searchParams.set('q', q);
                url.searchParams.set('limit', '20');
                const res = await fetch(url.toString(), { headers: { 'Accept': 'application/json' } });
                const data = await res.json();
                renderItems(data.items || []);
            } catch (e) {
                // fail silently
            }
        };

        locationInput.addEventListener('focus', () => { fetchItems(locationInput.value.trim()); });
        locationInput.addEventListener('input', function() {
            this.dataset.autofilled = '';
            clearTimeout(debounceId);
            debounceId = setTimeout(() => fetchItems(locationInput.value.trim()), 250);
        });
        document.addEventListener('click', (e) => {
            if (!dd.contains(e.target) && e.target !== locationInput) {
                dd.classList.add('hidden');
            }
        });
    }
});
</script>
@endpush
