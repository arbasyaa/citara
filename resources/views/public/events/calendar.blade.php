@extends('layouts.public')

@section('title', __('site.event_calendar'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 opacity-10"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-6 animate-fade-in">
                    {{ __('site.event_calendar') }}
                </h1>
                <p class="text-xl text-gray-600 leading-relaxed">
                    {{ __('site.event_calendar_subtitle') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Calendar Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <!-- Year Selector -->
            <div class="flex justify-center items-center gap-4 mb-12">
                <button onclick="changeYear(-1)" class="p-3 rounded-full bg-white shadow-lg hover:shadow-xl hover:bg-blue-50 transition-all">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <h2 id="currentYear" class="text-3xl font-bold text-gray-900">{{ date('Y') }}</h2>
                <button onclick="changeYear(1)" class="p-3 rounded-full bg-white shadow-lg hover:shadow-xl hover:bg-blue-50 transition-all">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <!-- Month Selector (visible only in single-month mode) -->
            <div id="monthSelector" class="hidden flex justify-center items-center gap-3 mb-10">
                <button onclick="changeMonth(-1)" class="p-2 rounded-full bg-white border border-gray-200 shadow-sm hover:bg-blue-50 transition-colors">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div class="px-4 py-2 rounded-full bg-white border border-gray-200 shadow-sm text-sm text-gray-700">
                    <span class="text-gray-500">Sedang melihat:</span>
                    <span id="currentMonthLabel" class="font-semibold text-gray-900"></span>
                    <span id="currentMonthYear" class="ml-1 text-gray-600"></span>
                </div>
                <button onclick="changeMonth(1)" class="p-2 rounded-full bg-white border border-gray-200 shadow-sm hover:bg-blue-50 transition-colors">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <a href="{{ route('events.calendar') }}" class="ml-3 text-sm text-blue-700 hover:text-blue-800">Lihat semua bulan</a>
            </div>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $month)
                    <div class="calendar-month bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden group cursor-pointer"
                    data-month="{{ $index + 1 }}"
                    onclick="onMonthCardClick({{ $index + 1 }})">
                        <!-- Month Header (clean style) -->
                        <div class="p-5 bg-white border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white font-bold">{{ substr($month,0,1) }}</span>
                                    <h3 class="text-base font-semibold text-gray-900">{{ $month }}</h3>
                                </div>
                                <div class="event-count hidden text-xs font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100"
                                     id="count-{{ $index + 1 }}">
                                    0
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Klik untuk lihat kegiatan</p>
                        </div>

                        <!-- Events Dropdown (Hidden by default) -->
                        <div id="events-{{ $index + 1 }}" class="events-container hidden max-h-0 overflow-hidden transition-all duration-300">
                            <div class="p-6 bg-gray-50">
                                <div class="space-y-4" id="events-list-{{ $index + 1 }}">
                                    <!-- Events will be loaded here dynamically -->
                                    <div class="text-center text-gray-500 py-8">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p>Tidak ada kegiatan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Legend Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Legenda</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg">
                        <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                        <span class="text-gray-700">Festival & Acara Besar</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-green-50 rounded-lg">
                        <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                        <span class="text-gray-700">Workshop & Pelatihan</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-purple-50 rounded-lg">
                        <div class="w-4 h-4 bg-purple-500 rounded-full"></div>
                        <span class="text-gray-700">Pameran & Bazar</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
let currentYear = {{ $initialYear ?? date('Y') }};
let eventsData = @json($events);
let openMonth = null;
// If server provided an initialMonth (1-12) we'll try to open it after load
let initialMonth = {{ $initialMonth ?? 'null' }};
let singleMonthMode = false;
const monthNamesId = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

// Load events on page load
document.addEventListener('DOMContentLoaded', function() {
    // render events for the initial year
    loadEventsForYear(currentYear);

    // If an initial month was requested, enter single-month mode focused on that month
    if (initialMonth && Number.isInteger(initialMonth) && initialMonth >= 1 && initialMonth <= 12) {
        setTimeout(() => {
            enterSingleMonthMode(initialMonth);
        }, 150);
    }
});

function changeYear(delta) {
    currentYear += delta;
    document.getElementById('currentYear').textContent = currentYear;
    loadEventsForYear(currentYear);
    
    // Close any open month
    if (openMonth) {
        toggleMonth(openMonth);
        openMonth = null;
    }
}

function loadEventsForYear(year) {
    // Filter events by year and month
    for (let month = 1; month <= 12; month++) {
        const monthEvents = eventsData.filter(event => {
            return event.month === month;
        });
        
        updateMonthDisplay(month, monthEvents);
    }
}

function updateMonthDisplay(month, events) {
    const countEl = document.getElementById(`count-${month}`);
    const listEl = document.getElementById(`events-list-${month}`);
    
    if (events.length > 0) {
        countEl.textContent = events.length;
        countEl.classList.remove('hidden');
        
        listEl.innerHTML = events.map(event => `
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-all duration-200 animate-fade-in">
                ${event.image ? `
                    <div class="h-44 overflow-hidden">
                        <img src="${event.image}" 
                             alt="${event.title}" 
                             class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-300"
                             loading="lazy"
                             decoding="async">
                    </div>
                ` : ''}
                <div class="p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm text-gray-600">${event.date_range || 'Tanggal belum ditentukan'}</span>
                    </div>
                    <h4 class="text-base font-semibold text-gray-900 mb-2 hover:text-blue-700 transition-colors">
                        ${event.title}
                    </h4>
                    <p class="text-gray-600 text-sm line-clamp-3 mb-3">
                        ${event.description || 'Tidak ada deskripsi'}
                    </p>
                    ${event.location ? `
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>${event.location}</span>
                        </div>
                    ` : ''}
                </div>
            </div>
        `).join('');
    } else {
        countEl.classList.add('hidden');
        listEl.innerHTML = `
            <div class="text-center text-gray-500 py-8">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p>Tidak ada kegiatan di bulan ini</p>
            </div>
        `;
    }
}

function toggleMonth(month) {
    const container = document.getElementById(`events-${month}`);
    const isOpen = !container.classList.contains('hidden');
    
    // Close previously open month
    if (openMonth && openMonth !== month) {
        const prevContainer = document.getElementById(`events-${openMonth}`);
        prevContainer.classList.add('hidden');
        prevContainer.style.maxHeight = '0px';
    }
    
    if (isOpen) {
        container.style.maxHeight = '0px';
        setTimeout(() => {
            container.classList.add('hidden');
        }, 300);
        openMonth = null;
    } else {
        container.classList.remove('hidden');
        setTimeout(() => {
            container.style.maxHeight = container.scrollHeight + 'px';
        }, 10);
        openMonth = month;
        
        // Smooth scroll to the month card
        const monthCard = document.querySelector(`[data-month="${month}"]`);
        if (monthCard) {
            setTimeout(() => {
                monthCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 300);
        }
    }
}

function onMonthCardClick(month) {
    if (singleMonthMode) {
        // In single-month mode, clicking toggles the dropdown only
        toggleMonth(month);
        return;
    }
    // Otherwise, go into single-month mode focusing on that month
    enterSingleMonthMode(month);
}

function enterSingleMonthMode(month) {
    singleMonthMode = true;
    // Show month selector header
    document.getElementById('monthSelector').classList.remove('hidden');
    document.getElementById('currentMonthLabel').textContent = monthNamesId[month - 1];
    document.getElementById('currentMonthYear').textContent = currentYear;

    // Hide all other months' cards except this month
    for (let m = 1; m <= 12; m++) {
        const card = document.querySelector(`.calendar-month[data-month="${m}"]`);
        if (!card) continue;
        if (m === month) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    }
    // Ensure the selected month dropdown is opened
    setTimeout(() => toggleMonth(month), 50);

    // Update URL query params without reloading
    const url = new URL(window.location.href);
    url.searchParams.set('year', currentYear);
    url.searchParams.set('month', month);
    window.history.replaceState({}, '', url.toString());
}

function changeMonth(delta) {
    if (!singleMonthMode) return;
    let newMonth = 1;
    const url = new URL(window.location.href);
    const currentParam = parseInt(url.searchParams.get('month') || initialMonth || 1, 10);
    newMonth = currentParam + delta;
    if (newMonth < 1) newMonth = 12;
    if (newMonth > 12) newMonth = 1;

    // Update header labels
    document.getElementById('currentMonthLabel').textContent = monthNamesId[newMonth - 1];
    document.getElementById('currentMonthYear').textContent = currentYear;

    // Show only the new month card and open it
    for (let m = 1; m <= 12; m++) {
        const card = document.querySelector(`.calendar-month[data-month="${m}"]`);
        const container = document.getElementById(`events-${m}`);
        if (!card) continue;
        if (m === newMonth) {
            card.classList.remove('hidden');
            // Ensure it's opened
            container.classList.add('hidden');
            container.style.maxHeight = '0px';
            setTimeout(() => toggleMonth(m), 30);
        } else {
            card.classList.add('hidden');
            container.classList.add('hidden');
            container.style.maxHeight = '0px';
        }
    }

    // Sync URL param
    url.searchParams.set('year', currentYear);
    url.searchParams.set('month', newMonth);
    window.history.replaceState({}, '', url.toString());
}
</script>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.events-container {
    transition: max-height 0.3s ease-in-out;
}
</style>
@endpush
@endsection
