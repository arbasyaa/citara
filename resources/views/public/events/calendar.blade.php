@extends('layouts.public')

@section('title', __('site.event_calendar'))

@push('styles')
<style>
    .hero-calendar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }
    
    .hero-calendar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="30" cy="25" r="1.5" fill="white" opacity="0.1"/><circle cx="70" cy="15" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/><circle cx="85" cy="75" r="1" fill="white" opacity="0.1"/></svg>');
        animation: float 20s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .month-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        isolation: isolate;
    }
    
    .month-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }
    
    .month-card.active {
        border-color: #3B82F6;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.2);
    }

    .event-item {
        transition: all 0.2s ease;
    }
    
    .event-item:hover {
        transform: translateX(4px);
        background: #F9FAFB;
    }

    @keyframes fadeIn {
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
        animation: fadeIn 0.4s ease-out;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <section class="hero-calendar py-24 relative">
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-md rounded-full mb-6">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-semibold text-white uppercase tracking-wide">Kalender Event</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-black text-white mb-6">
                    {{ __('site.event_calendar') }}
                </h1>
                <p class="text-xl text-white/90 leading-relaxed">
                    Event dan kegiatan tahunan di Cilacap
                </p>
            </div>
        </div>
    </section>

    <!-- Calendar Section -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <!-- Year Selector -->
            <div class="flex justify-center items-center gap-6 mb-12">
                <button onclick="changeYear(-1)" class="group p-4 rounded-xl bg-white shadow-md hover:shadow-lg hover:bg-blue-600 transition-all duration-300">
                    <svg class="w-6 h-6 text-gray-700 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <div class="text-center">
                    <p class="text-sm text-gray-500 mb-1">Tahun</p>
                    <h2 id="currentYear" class="text-4xl font-black text-gray-900">{{ date('Y') }}</h2>
                </div>
                <button onclick="changeYear(1)" class="group p-4 rounded-xl bg-white shadow-md hover:shadow-lg hover:bg-blue-600 transition-all duration-300">
                    <svg class="w-6 h-6 text-gray-700 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <!-- Month Selector (visible only in single-month mode) -->
            <div id="monthSelector" class="hidden mb-10">
                <div class="bg-white rounded-2xl shadow-lg p-6 max-w-2xl mx-auto">
                    <div class="flex items-center justify-between">
                        <button onclick="changeMonth(-1)" class="p-3 rounded-xl bg-gray-100 hover:bg-blue-600 hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <div class="text-center flex-1">
                            <p class="text-sm text-gray-500 mb-1">Sedang melihat</p>
                            <h3 class="text-2xl font-bold text-gray-900">
                                <span id="currentMonthLabel"></span>
                                <span id="currentMonthYear" class="text-gray-600"></span>
                            </h3>
                        </div>
                        <button onclick="changeMonth(1)" class="p-3 rounded-xl bg-gray-100 hover:bg-blue-600 hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('events.calendar') }}" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            Lihat semua bulan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $month)
                    <div class="calendar-month month-card bg-white rounded-2xl border-2 border-gray-200 shadow-sm overflow-hidden cursor-pointer"
                         data-month="{{ $index + 1 }}"
                         onclick="onMonthCardClick({{ $index + 1 }})">
                        <!-- Month Header -->
                        <div class="p-6 bg-gradient-to-br from-blue-50 to-purple-50 border-b-2 border-gray-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center shadow-lg">
                                        <span class="text-white font-black text-lg">{{ substr($month,0,1) }}</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $month }}</h3>
                                </div>
                                <div class="event-count hidden text-sm font-bold text-white bg-blue-600 px-3 py-1.5 rounded-full shadow-md"
                                     id="count-{{ $index + 1 }}">
                                    0
                                </div>
                            </div>
                            <button class="text-sm text-blue-700 hover:text-blue-800 font-medium flex items-center gap-1 group">
                                <span>Klik untuk lihat kegiatan</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Events Dropdown -->
                        <div id="events-{{ $index + 1 }}" class="events-container hidden max-h-0 overflow-hidden transition-all duration-300">
                            <div class="p-6 bg-white">
                                <div class="space-y-4" id="events-list-{{ $index + 1 }}">
                                    <!-- Events loaded dynamically -->
                                    <div class="text-center text-gray-400 py-12">
                                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="font-medium">Tidak ada kegiatan</p>
                                        <p class="text-sm mt-1">di bulan ini</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Info Section -->
    <section class="py-16 bg-white border-t border-gray-200">
        <div class="container mx-auto px-6">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-black text-gray-900 mb-3">Informasi Event</h3>
                    <p class="text-gray-600">Jelajahi berbagai event menarik di Cilacap sepanjang tahun</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="group p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl border-2 border-blue-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Festival & Acara</h4>
                        <p class="text-gray-700 text-sm leading-relaxed">Event besar dengan berbagai pertunjukan budaya dan hiburan</p>
                    </div>
                    
                    <div class="group p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl border-2 border-green-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-14 h-14 bg-green-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Workshop & Kelas</h4>
                        <p class="text-gray-700 text-sm leading-relaxed">Pelatihan dan pembelajaran keterampilan baru yang bermanfaat</p>
                    </div>
                    
                    <div class="group p-6 bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl border-2 border-purple-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-14 h-14 bg-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Pameran & Bazar</h4>
                        <p class="text-gray-700 text-sm leading-relaxed">Pameran produk lokal dan bazar UMKM yang menarik</p>
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
            <div class="event-item group bg-white rounded-xl border-2 border-gray-200 shadow-sm overflow-hidden hover:border-blue-400 transition-all duration-200 animate-fade-in">
                ${event.image ? `
                    <div class="h-48 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                        <img src="${event.image}" 
                             alt="${event.title}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy"
                             decoding="async">
                    </div>
                ` : `
                    <div class="h-48 bg-gradient-to-br from-blue-400 via-purple-500 to-pink-500 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                `}
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 rounded-full">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-blue-700">${event.date_range || 'TBA'}</span>
                        </div>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-700 transition-colors leading-tight">
                        ${event.title}
                    </h4>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-2">
                        ${event.description || 'Deskripsi event akan segera tersedia'}
                    </p>
                    ${event.location ? `
                        <div class="flex items-start gap-2 text-sm text-gray-500 pt-3 border-t border-gray-100">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="flex-1">${event.location}</span>
                        </div>
                    ` : ''}
                </div>
            </div>
        `).join('');
    } else {
        countEl.classList.add('hidden');
        listEl.innerHTML = `
            <div class="text-center text-gray-400 py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="font-medium text-gray-900">Tidak ada kegiatan</p>
                <p class="text-sm mt-1">di bulan ini</p>
            </div>
        `;
    }
}

function toggleMonth(month) {
    const container = document.getElementById(`events-${month}`);
    const monthCard = document.querySelector(`[data-month="${month}"]`);
    const isOpen = !container.classList.contains('hidden');
    
    // Close previously open month
    if (openMonth && openMonth !== month) {
        const prevContainer = document.getElementById(`events-${openMonth}`);
        const prevCard = document.querySelector(`[data-month="${openMonth}"]`);
        prevContainer.classList.add('hidden');
        prevContainer.style.maxHeight = '0px';
        if (prevCard) prevCard.classList.remove('active');
    }
    
    if (isOpen) {
        container.style.maxHeight = '0px';
        setTimeout(() => {
            container.classList.add('hidden');
        }, 300);
        if (monthCard) monthCard.classList.remove('active');
        openMonth = null;
    } else {
        container.classList.remove('hidden');
        if (monthCard) monthCard.classList.add('active');
        setTimeout(() => {
            container.style.maxHeight = container.scrollHeight + 'px';
        }, 10);
        openMonth = month;
        
        // Smooth scroll to the month card
        if (monthCard) {
            setTimeout(() => {
                monthCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 200);
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
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.events-container {
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Smooth animations */
@media (prefers-reduced-motion: no-preference) {
    .month-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .event-item {
        transition: all 0.25s ease;
    }
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .month-card {
        transform: none !important;
    }
    
    .month-card:hover {
        transform: none !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
}
</style>
@endpush
@endsection
