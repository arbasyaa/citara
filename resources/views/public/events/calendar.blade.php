@extends('layouts.public')

@section('title', __('site.event_calendar'))

@push('styles')
<style>
    /* Professional Calendar Styles - Consistent with Main Web */
    .hero-calendar {
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 82, 167, 0.6) 100%);
        position: relative;
        min-height: 300px;
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
    }

    .month-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        isolation: isolate;
        border-radius: 12px;
    }
    
    .month-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .month-card.active {
        border-color: #0052A7;
        box-shadow: 0 12px 30px rgba(0, 82, 167, 0.25);
    }

    .event-item {
        transition: all 0.3s ease;
        border-radius: 8px;
    }
    
    .event-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .events-container {
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
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

    /* Compact Date Selector */
    .date-selector {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .date-selector select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }

    /* Search Filter Selects */
    select {
        cursor: pointer;
    }
    
    select:focus {
        outline: none;
    }

    #searchFilterMonth,
    #searchFilterYear {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
        background-position: right 0.25rem center;
        background-repeat: no-repeat;
        background-size: 1.25em 1.25em;
    }

    /* Responsive */
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

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section - Professional & Minimal -->
    <section class="hero-calendar py-16 relative">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-md rounded-lg mb-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-xs font-semibold text-white uppercase tracking-wide">Kalender Event</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                            {{ __('site.event_calendar') }}
                        </h1>
                        <p class="text-base text-white/80">
                            Event dan kegiatan tahunan di Cilacap
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Calendar Section -->
    <section class="py-12">
        <div class="container mx-auto px-6">
            <!-- Search Bar with Filters -->
            <div class="max-w-5xl mx-auto mb-8">
                <div class="flex flex-col md:flex-row gap-3 items-stretch md:items-center">
                    <!-- Search Input -->
                    <div class="relative flex-1 flex items-center gap-2">
                        <div class="relative flex-1">
                            <input type="text" id="eventSearch" placeholder="Cari event atau kegiatan..." 
                                   class="w-full h-[44px] px-4 py-3 pl-12 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                            <div class="absolute left-4 top-0 bottom-0 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                        <button id="runSearchBtn" type="button" class="h-[44px] px-4 inline-flex items-center gap-2 rounded-lg border border-gray-300 hover:border-blue-500 hover:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span class="text-sm font-medium">Cari</span>
                        </button>
                    </div>
                    
                    <!-- Time Range Filters -->
                    <div class="flex items-center gap-2 bg-white rounded-lg border border-gray-300 px-3 h-[44px]">
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <select id="searchFilterMonth" class="text-sm text-gray-700 border-0 focus:ring-0 bg-transparent pr-6 py-2">
                            <option value="">Semua Bulan</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <div class="h-6 w-px bg-gray-300"></div>
                        <select id="searchFilterYear" class="text-sm font-medium text-gray-700 border-0 focus:ring-0 bg-transparent pr-6">
                            <option value="">Semua Tahun</option>
                            @for($y = date('Y') - 2; $y <= date('Y') + 5; $y++)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                
                <!-- Active Filters Info -->
                <div id="activeFiltersInfo" class="mt-3 hidden">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span id="filterInfoText">Mencari di semua periode</span>
                        </div>
                        <button id="resetSearchBtn" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">Reset</button>
                    </div>
                </div>

                <!-- No Results Message -->
                <div id="noResultsMessage" class="mt-4 hidden">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Maaf, tidak ada acara untuk filter yang dipilih.</span>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $month)
                    <div class="calendar-month month-card bg-white border border-gray-200 shadow-sm overflow-hidden cursor-pointer"
                         data-month="{{ $index + 1 }}"
                         onclick="onMonthCardClick({{ $index + 1 }})">
                        <!-- Month Header - Professional & Minimal -->
                        <div class="p-5 bg-gradient-to-br from-gray-50 to-blue-50/30 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">{{ substr($month,0,3) }}</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $month }}</h3>
                                        <p class="text-xs text-gray-500">Lihat kegiatan</p>
                                    </div>
                                </div>
                                <div class="event-count hidden text-xs font-bold text-white bg-blue-600 px-2.5 py-1 rounded-full"
                                     id="count-{{ $index + 1 }}">
                                    0
                                </div>
                            </div>
                        </div>

                        <!-- Events Dropdown -->
                        <div id="events-{{ $index + 1 }}" class="events-container hidden max-h-0 overflow-hidden">
                            <div class="p-5 bg-white">
                                <div class="space-y-3" id="events-list-{{ $index + 1 }}">
                                    <!-- Events loaded dynamically -->
                                    <div class="text-center text-gray-400 py-8">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-sm font-medium text-gray-500">Tidak ada kegiatan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Info Section - Professional & Minimal -->
    <section class="py-12 bg-white border-t border-gray-200">
        <div class="container mx-auto px-6">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-10">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Jenis Event</h3>
                    <p class="text-sm text-gray-600">Berbagai kegiatan menarik sepanjang tahun</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="group p-5 bg-white border border-gray-200 rounded-xl hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/>
                            </svg>
                        </div>
                        <h4 class="text-base font-bold text-gray-900 mb-2">Festival & Acara</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Event besar dengan berbagai pertunjukan budaya dan hiburan</p>
                    </div>
                    
                    <div class="group p-5 bg-white border border-gray-200 rounded-xl hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h4 class="text-base font-bold text-gray-900 mb-2">Workshop & Kelas</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Pelatihan dan pembelajaran keterampilan baru yang bermanfaat</p>
                    </div>
                    
                    <div class="group p-5 bg-white border border-gray-200 rounded-xl hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <h4 class="text-base font-bold text-gray-900 mb-2">Pameran & Bazar</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Pameran produk lokal dan bazar UMKM yang menarik</p>
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
let initialMonth = {{ $initialMonth ?? 'null' }};
let searchTerm = '';
let searchFilterMonth = '';
let searchFilterYear = '';
let searchActive = false; // true when a search query/filter is applied
const monthNamesId = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

// Load events on page load
document.addEventListener('DOMContentLoaded', function() {
    loadEventsForYear(currentYear);
    // If navigated from homepage with a chosen month, open that month while keeping others visible
    if (initialMonth && Number.isInteger(initialMonth) && initialMonth >= 1 && initialMonth <= 12) {
        setTimeout(() => openMonthKeepOthers(initialMonth), 200);
    }
    
    // Search functionality with real-time filter update
    const searchInput = document.getElementById('eventSearch');
    if (searchInput) {
        // Run on Enter
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                runSearch();
            }
        });
        // Update live but do not filter cards yet; keep explicit run
        searchInput.addEventListener('input', function(e) {
            searchTerm = e.target.value.trim().toLowerCase();
            updateFilterInfo();
        });
    }

    // Run search button
    const runBtn = document.getElementById('runSearchBtn');
    if (runBtn) {
        runBtn.addEventListener('click', runSearch);
    }
    
    // Search filter - Month
    const searchMonthFilter = document.getElementById('searchFilterMonth');
    if (searchMonthFilter) {
        searchMonthFilter.addEventListener('change', function(e) {
            searchFilterMonth = e.target.value;
            searchActive = !!searchFilterMonth || !!searchFilterYear || !!searchTerm;
            loadEventsForYear(currentYear);
            updateFilterInfo();
        });
    }
    
    // Search filter - Year
    const searchYearFilter = document.getElementById('searchFilterYear');
    if (searchYearFilter) {
        searchYearFilter.addEventListener('change', function(e) {
            searchFilterYear = e.target.value;
            searchActive = !!searchFilterMonth || !!searchFilterYear || !!searchTerm;
            loadEventsForYear(currentYear);
            updateFilterInfo();
        });
    }
    
    // Reset search button
    const resetBtn = document.getElementById('resetSearchBtn');
    if (resetBtn) {
        resetBtn.addEventListener('click', resetSearch);
    }
    
});

function runSearch() {
    const hasQuery = !!searchTerm || !!searchFilterMonth || !!searchFilterYear;
    if (!hasQuery) {
        resetSearch();
        return;
    }
    searchActive = true;

    let matchingMonths = [];
    for (let m = 1; m <= 12; m++) {
        const card = document.querySelector(`.calendar-month[data-month="${m}"]`);
        if (!card) continue;
        const filteredEvents = getFilteredEventsForMonth(m);
        updateMonthDisplay(m, filteredEvents);
        if (filteredEvents.length > 0) {
            card.classList.remove('hidden');
            matchingMonths.push(m);
        } else {
            card.classList.add('hidden');
        }
    }
    // Open all matching months without closing others
    matchingMonths.forEach(month => openMonthKeepOthers(month));
    updateFilterInfo();
}

function resetSearch() {
    searchTerm = '';
    searchFilterMonth = '';
    searchFilterYear = '';
    searchActive = false;
    
    const searchInput = document.getElementById('eventSearch');
    const searchMonthFilter = document.getElementById('searchFilterMonth');
    const searchYearFilter = document.getElementById('searchFilterYear');
    
    if (searchInput) searchInput.value = '';
    if (searchMonthFilter) searchMonthFilter.value = '';
    if (searchYearFilter) searchYearFilter.value = '';

    document.querySelectorAll('.calendar-month').forEach(card => {
        card.classList.remove('hidden');
    });
    
    loadEventsForYear(currentYear); // Reload all events
    closeAllMonths(); // collapse any previously opened (single open mode restored)
    updateFilterInfo();
}

function updateFilterInfo() {
    const infoContainer = document.getElementById('activeFiltersInfo');
    const infoText = document.getElementById('filterInfoText');
    
    if (!searchTerm && !searchFilterMonth && !searchFilterYear) {
        infoContainer.classList.add('hidden');
        return;
    }
    
    infoContainer.classList.remove('hidden');
    
    let parts = [];
    if (searchTerm) parts.push(`"${searchTerm}"`);
    if (searchFilterMonth) parts.push(monthNamesId[parseInt(searchFilterMonth) - 1]);
    if (searchFilterYear) parts.push(searchFilterYear);
    
    if (parts.length === 0) {
        infoText.textContent = 'Mencari di semua periode';
    } else if (searchTerm && !searchFilterMonth && !searchFilterYear) {
        infoText.textContent = `Mencari "${searchTerm}" di semua periode`;
    } else {
        let periodText = [];
        if (searchFilterMonth) periodText.push(monthNamesId[parseInt(searchFilterMonth) - 1]);
        if (searchFilterYear) periodText.push(searchFilterYear);
        
        if (searchTerm) {
            infoText.textContent = `Mencari "${searchTerm}" di ${periodText.join(' ')}`;
        } else {
            infoText.textContent = `Menampilkan event di ${periodText.join(' ')}`;
        }
    }
}

function changeYear(delta) {
    currentYear += delta;
    const yearSelect = document.getElementById('filterYear');
    if (yearSelect) {
        yearSelect.value = currentYear;
    }
    loadEventsForYear(currentYear);
    closeAllMonths();
}

function loadEventsForYear(year) {
    let anyVisible = false;
    const hasFilter = !!searchFilterMonth || !!searchFilterYear || !!searchTerm;
    for (let month = 1; month <= 12; month++) {
        const monthEvents = getFilteredEventsForMonth(month);
        updateMonthDisplay(month, monthEvents);
        const card = document.querySelector(`.calendar-month[data-month="${month}"]`);
        if (!card) continue;
        if (hasFilter) {
            if (monthEvents.length > 0) {
                card.classList.remove('hidden');
                anyVisible = true;
            } else {
                card.classList.add('hidden');
            }
        } else {
            card.classList.remove('hidden');
        }
    }
    const noMsg = document.getElementById('noResultsMessage');
    if (noMsg) {
        if (hasFilter && !anyVisible) {
            noMsg.classList.remove('hidden');
        } else {
            noMsg.classList.add('hidden');
        }
    }
}

function getFilteredEventsForMonth(month) {
    // First check if we're filtering by month and this isn't the filtered month
    if (searchFilterMonth) {
        const filterMonth = parseInt(searchFilterMonth);
        if (month !== filterMonth) {
            return []; // Return empty array for non-matching months
        }
    }
    
    // Get events for this month
    let events = eventsData.filter(event => {
        if (!event || typeof event.month !== 'number') return false; // guard against malformed event objects
        return event.month === month;
    });

    // Year filter if event has year property
    if (searchFilterYear) {
        const fy = parseInt(searchFilterYear);
        events = events.filter(event => {
            // Accept if event.year matches; if missing, try inferring from date_range (best-effort)
            if (typeof event.year === 'number') {
                return event.year === fy;
            }
            // Optional: if start_date available in payload
            if (event.start_date) {
                const y = new Date(event.start_date).getFullYear();
                return y === fy;
            }
            return false;
        });
    }
    
    // Apply search text filter
    if (searchTerm) {
        events = events.filter(event => {
            const searchable = [
                event.title || '',
                event.description || '',
                event.location_label || '',
                event.location_address || '',
                event.location || ''
            ].join(' ').toLowerCase();
            return searchable.includes(searchTerm);
        });
    }
    
    return events;
}

function updateMonthDisplay(month, events) {
    const countEl = document.getElementById(`count-${month}`);
    const listEl = document.getElementById(`events-list-${month}`);
    const container = document.getElementById(`events-${month}`);
    
    if (events.length > 0) {
        countEl.textContent = events.length;
        countEl.classList.remove('hidden');
        
        listEl.innerHTML = events.map(event => {
            // Define category styles and icons
            const categoryConfig = {
                festival: {
                    label: 'Festival & Acara',
                    bgColor: 'bg-blue-600',
                    textColor: 'text-white',
                    icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/>
                    </svg>`
                },
                workshop: {
                    label: 'Workshop & Kelas',
                    bgColor: 'bg-green-600',
                    textColor: 'text-white',
                    icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>`
                },
                pameran: {
                    label: 'Pameran & Bazar',
                    bgColor: 'bg-purple-600',
                    textColor: 'text-white',
                    icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>`
                }
            };
            const category = categoryConfig[event.category] || categoryConfig.festival;
            
            return `
            <div class="event-item group bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-all duration-300">
                <div class="relative">
                    ${event.image ? `
                        <div class="h-40 overflow-hidden bg-gray-100">
                            <img src="${event.image}" 
                                 alt="${event.title}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 loading="lazy">
                        </div>
                    ` : `
                        <div class="h-40 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    `}
                    <div class="absolute top-3 left-3">
                        <div class="flex items-center gap-1.5 px-2.5 py-1.5 ${category.bgColor} rounded-lg shadow-lg">
                            ${category.icon}
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-blue-700 bg-blue-50 rounded-md">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            ${event.date_range || 'TBA'}
                        </span>
                    </div>
                    <h4 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                        ${event.title}
                    </h4>
                    <p class="text-gray-600 text-sm leading-relaxed mb-3 line-clamp-2">
                        ${event.description || 'Deskripsi akan segera tersedia'}
                    </p>
                    ${(event.location_label || event.location) ? `
                        <div class="flex items-start gap-2 text-xs text-gray-500 pt-2 border-t border-gray-100">
                            <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="flex-1 line-clamp-1">${event.location_label || event.location}</span>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
        }).join('');
    } else {
        countEl.classList.add('hidden');
        // If in search mode: keep empty (month will be hidden). Otherwise show placeholder.
        if (searchActive) {
            listEl.innerHTML = ``;
        } else {
            listEl.innerHTML = `<div class="text-center text-gray-400 py-8">
                <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-sm font-medium text-gray-500">Tidak ada kegiatan</p>
            </div>`;
        }
    }

    // Recalculate height if container already open (multi-open search or manual toggle)
    if (container && !container.classList.contains('hidden')) {
        // allow time for images to load, then adjust height
        setTimeout(() => { container.style.maxHeight = container.scrollHeight + 'px'; }, 30);
    }
}

function toggleMonth(month) {
    const container = document.getElementById(`events-${month}`);
    const monthCard = document.querySelector(`[data-month="${month}"]`);
    if (!container) return;
    const isOpen = !container.classList.contains('hidden');

    // When searchActive, allow independent toggling without affecting others
    if (searchActive) {
        if (isOpen) {
            container.style.maxHeight = '0px';
            setTimeout(() => container.classList.add('hidden'), 300);
            if (monthCard) monthCard.classList.remove('active');
        } else {
            container.classList.remove('hidden');
            if (monthCard) monthCard.classList.add('active');
            setTimeout(() => { container.style.maxHeight = container.scrollHeight + 'px'; }, 10);
        }
        return; // Skip single-open logic
    }

    // Original single-open behavior when not searching
    if (openMonth && openMonth !== month) {
        const prevContainer = document.getElementById(`events-${openMonth}`);
        const prevCard = document.querySelector(`[data-month="${openMonth}"]`);
        const currentCard = document.querySelector(`[data-month="${month}"]`);
        let sameRow = false;
        if (currentCard && prevCard) {
            sameRow = currentCard.offsetTop === prevCard.offsetTop;
        }
        // If cards are on the same row, keep previous open to avoid drag-down effect
        if (!sameRow) {
            if (prevContainer) {
                prevContainer.classList.add('hidden');
                prevContainer.style.maxHeight = '0px';
            }
            if (prevCard) prevCard.classList.remove('active');
        }
    }
    if (isOpen) {
        container.style.maxHeight = '0px';
        setTimeout(() => container.classList.add('hidden'), 300);
        if (monthCard) monthCard.classList.remove('active');
        openMonth = null;
    } else {
        // Determine if we should perform scroll animation based on row alignment
        let shouldScroll = false;
        if (openMonth && openMonth !== month) {
            const currentCard = document.querySelector(`[data-month="${month}"]`);
            const previousCard = document.querySelector(`[data-month="${openMonth}"]`);
            if (currentCard && previousCard) {
                const currentTop = currentCard.offsetTop;
                const previousTop = previousCard.offsetTop;
                // Scroll only if cards are in different horizontal rows
                shouldScroll = currentTop !== previousTop;
            }
        }

        container.classList.remove('hidden');
        if (monthCard) monthCard.classList.add('active');
        setTimeout(() => { container.style.maxHeight = container.scrollHeight + 'px'; }, 10);
        openMonth = month;
        if (shouldScroll) {
            setTimeout(() => { if (monthCard) monthCard.scrollIntoView({ behavior: 'smooth', block: 'center' }); }, 200);
        }
    }
}

// Open month keeping others open (used for multi-month search and initial deep-link)
function openMonthKeepOthers(month) {
    const container = document.getElementById(`events-${month}`);
    const monthCard = document.querySelector(`[data-month="${month}"]`);
    if (!container || !monthCard) return;
    container.classList.remove('hidden');
    monthCard.classList.add('active');
    container.style.maxHeight = container.scrollHeight + 'px';
}

function onMonthCardClick(month) {
    toggleMonth(month);
}

function filterByMonth(month) {
    // Hide all months except selected
    for (let m = 1; m <= 12; m++) {
        const card = document.querySelector(`.calendar-month[data-month="${m}"]`);
        if (card) {
            if (m === month) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        }
    }
    // Auto-open the selected month
    setTimeout(() => toggleMonth(month), 100);
}

function showAllMonths() {
    // Show all month cards
    for (let m = 1; m <= 12; m++) {
        const card = document.querySelector(`.calendar-month[data-month="${m}"]`);
        if (card) card.classList.remove('hidden');
    }
    closeAllMonths();
}

function closeAllMonths() {
    document.querySelectorAll('.events-container').forEach(c => {
        c.classList.add('hidden');
        c.style.maxHeight = '0px';
    });
    document.querySelectorAll('.calendar-month').forEach(card => card.classList.remove('active'));
    openMonth = null;
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

.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
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
