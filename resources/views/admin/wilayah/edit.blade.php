@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6">Edit Wilayah</h2>

        <!-- Calendar removed from wilayah edit to avoid confusion. Calendar events managed separately under 'Kalender' -->

    <form action="{{ route('panel.wilayah.update', $wilayah) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Wilayah</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $wilayah->nama) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('deskripsi', $wilayah->deskripsi) }}</textarea>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('panel.wilayah.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 mr-2">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarCard = document.querySelector('.group');
        const detailsSection = document.getElementById('calendarDetails');
        const monthsContainer = document.getElementById('monthsContainer');
        const monthRange = document.getElementById('monthRange');
        const prevButton = document.getElementById('prevMonths');
        const nextButton = document.getElementById('nextMonths');
        let currentStartMonth = 0;
        let isExpanded = false;

        const months = [
            { month: 'Januari', events: [{ date: '01-03', name: 'Festival Tahun Baru', location: 'Pantai Teluk Penyu' }] },
            { month: 'Februari', events: [{ date: '10-12', name: 'Festival Seni Budaya', location: 'Benteng Pendem' }] },
            { month: 'Maret', events: [{ date: '05-07', name: 'Festival Seafood', location: 'Pelabuhan Perikanan' }] },
            { month: 'April', events: [{ date: '12-14', name: 'Festival Musik Tradisional', location: 'Taman Kota' }] },
            { month: 'Mei', events: [{ date: '15-17', name: 'Festival Pantai', location: 'Pantai Widara Payung' }] },
            { month: 'Juni', events: [{ date: '08-10', name: 'Festival Seni Rupa', location: 'Pusat Kebudayaan' }] },
            { month: 'Juli', events: [{ date: '05-07', name: 'Festival Film', location: 'Bioskop Kota' }] },
            { month: 'Agustus', events: [{ date: '17-19', name: 'Festival Kemerdekaan', location: 'Alun-alun Kota' }] },
            { month: 'September', events: [{ date: '10-12', name: 'Festival Kesenian', location: 'Gedung Kesenian' }] },
            { month: 'Oktober', events: [{ date: '15-17', name: 'Festival Kuliner', location: 'Kawasan Kuliner' }] },
            { month: 'November', events: [{ date: '20-22', name: 'Festival Tradisional', location: 'Alun-alun Kota' }] },
            { month: 'Desember', events: [{ date: '25-31', name: 'Festival Tahun Baru', location: 'Pantai Teluk Penyu' }] }
        ];

        function updateMonths() {
            monthsContainer.innerHTML = '';
            const visibleMonths = months.slice(currentStartMonth, currentStartMonth + 3);
            
            visibleMonths.forEach(monthData => {
                const monthElement = document.createElement('div');
                monthElement.className = 'bg-gray-50 p-3 rounded-lg hover:bg-blue-50 transition-colors';
                monthElement.innerHTML = `
                    <h4 class="font-medium text-gray-700">${monthData.month}</h4>
                    <p class="text-sm text-gray-500">2026</p>
                    <div class="mt-2 text-xs text-gray-600">
                        ${monthData.events.map(event => `
                            <div class="mt-1 border-l-2 border-blue-400 pl-2">
                                ${event.date}: ${event.name}
                            </div>
                        `).join('')}
                    </div>
                `;
                monthsContainer.appendChild(monthElement);
            });

            monthRange.textContent = `${visibleMonths[0].month} - ${visibleMonths[visibleMonths.length - 1].month} 2026`;
            
            // Update button states
            prevButton.disabled = currentStartMonth === 0;
            nextButton.disabled = currentStartMonth >= months.length - 3;
            
            // Update visual state of buttons
            prevButton.classList.toggle('opacity-50', currentStartMonth === 0);
            nextButton.classList.toggle('opacity-50', currentStartMonth >= months.length - 3);
        }

        prevButton.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent card click event
            if (currentStartMonth > 0) {
                currentStartMonth -= 3;
                updateMonths();
            }
        });

        nextButton.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent card click event
            if (currentStartMonth < months.length - 3) {
                currentStartMonth += 3;
                updateMonths();
            }
        });

        // Handle card click for expanding details
        calendarCard.addEventListener('click', function() {
            if (!isExpanded) {
                detailsSection.classList.remove('hidden');
                setTimeout(() => {
                    detailsSection.classList.add('opacity-100', 'max-h-96');
                    detailsSection.classList.remove('opacity-0', 'max-h-0');
                }, 50);
            } else {
                detailsSection.classList.add('opacity-0', 'max-h-0');
                detailsSection.classList.remove('opacity-100', 'max-h-96');
                setTimeout(() => {
                    detailsSection.classList.add('hidden');
                }, 300);
            }
            isExpanded = !isExpanded;
        });

        // Initialize the calendar
        updateMonths();
    });
</script>
@endpush