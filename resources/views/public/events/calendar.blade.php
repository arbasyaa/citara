@extends('layouts.public')

@section('title', __('site.event_calendar_page_title'))

@push('styles')
<style>
/* ============================================
   MODERN PROFESSIONAL CALENDAR DESIGN SYSTEM
   Inspired by: Eventbrite, Airbnb, Google Events
   ============================================ */

:root {
    --primary: #2563EB;
    --primary-dark: #1E40AF;
    --accent: #F59E0B;
    --success: #10B981;
    --gray-50: #F9FAFB;
    --gray-100: #F3F4F6;
    --gray-200: #E5E7EB;
    --gray-300: #D1D5DB;
    --gray-400: #9CA3AF;
    --gray-500: #6B7280;
    --gray-600: #4B5563;
    --gray-700: #374151;
    --gray-800: #1F2937;
    --gray-900: #111827;
    --radius: 16px;
    --radius-md: 12px;
    --radius-sm: 8px;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

/* Hero Section - Minimal & Professional */
.calendar-hero {
    background: linear-gradient(135deg, #1E40AF 0%, #2563EB 50%, #3B82F6 100%);
    position: relative;
    overflow: hidden;
}

.calendar-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
    animation: heroGradient 20s ease infinite;
}

@keyframes heroGradient {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 0.8; }
}

/* Month Timeline Navigator */
.month-timeline {
    display: flex;
    gap: 0.5rem;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    scrollbar-color: var(--gray-300) transparent;
    padding-bottom: 0.5rem;
}

.month-timeline::-webkit-scrollbar {
    height: 4px;
}

.month-timeline::-webkit-scrollbar-track {
    background: transparent;
}

.month-timeline::-webkit-scrollbar-thumb {
    background: var(--gray-300);
    border-radius: 2px;
}

.month-timeline::-webkit-scrollbar-thumb:hover {
    background: var(--gray-400);
}

.month-pill {
    flex-shrink: 0;
    scroll-snap-align: start;
    padding: 0.625rem 1.25rem;
    border-radius: var(--radius-sm);
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--gray-700);
    background: white;
    border: 1.5px solid var(--gray-200);
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    white-space: nowrap;
}

.month-pill:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

.month-pill.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    box-shadow: var(--shadow-md);
}

/* Year Pills */
.year-pill {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: var(--radius-sm);
    background: white;
    color: var(--gray-700);
    border: 1.5px solid var(--gray-200);
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    white-space: nowrap;
}

.year-pill:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

.year-pill.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    box-shadow: var(--shadow-md);
}

/* Event Cards - Grid Layout */
.events-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .events-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .events-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Event item wrapper */
.event-item {
    width: 100%;
}

/* Hidden items should not take up grid space */
.event-item[style*="display: none"] {
    display: none !important;
}

/* Event Card - Professional Design */
.event-card {
    background: white;
    border-radius: var(--radius-md);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    border: 1px solid var(--gray-100);
}

.event-card:hover {
    box-shadow: var(--shadow-xl);
    transform: translateY(-4px);
    border-color: var(--gray-200);
}

.event-card-image {
    position: relative;
    width: 100%;
    height: 200px;
    background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
    overflow: hidden;
}

.event-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.event-card:hover .event-card-image img {
    transform: scale(1.05);
}

.event-category-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 0.375rem 0.75rem;
    border-radius: var(--radius-sm);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(8px);
    box-shadow: var(--shadow-md);
}

.category-festival {
    background: rgba(239, 68, 68, 0.9);
    color: white;
}

.category-workshop {
    background: rgba(59, 130, 246, 0.9);
    color: white;
}

.category-pameran {
    background: rgba(16, 185, 129, 0.9);
    color: white;
}

.event-date-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: white;
    padding: 0.5rem;
    border-radius: var(--radius-sm);
    box-shadow: var(--shadow-md);
    text-align: center;
    min-width: 56px;
}

.event-date-badge .day {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    color: var(--primary);
}

.event-date-badge .month {
    display: block;
    font-size: 0.625rem;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--gray-600);
    margin-top: 0.25rem;
    letter-spacing: 0.5px;
}

.event-card-content {
    padding: 1.25rem;
}

.event-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.event-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}

.event-meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--gray-600);
}

.event-meta-item svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
    color: var(--gray-400);
}

.event-description {
    font-size: 0.875rem;
    color: var(--gray-600);
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 1rem;
}

.event-card-footer {
    padding: 0 1.25rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.event-learn-more {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--primary);
    transition: gap 0.2s;
}

.event-card:hover .event-learn-more {
    gap: 0.75rem;
}

/* Filter Section */
.filter-bar {
    background: white;
    border-radius: var(--radius-md);
    padding: 1rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--gray-100);
}

.filter-group {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    align-items: center;
}

.filter-chip {
    padding: 0.5rem 1rem;
    border-radius: var(--radius-sm);
    font-size: 0.875rem;
    font-weight: 500;
    border: 1.5px solid var(--gray-200);
    background: white;
    color: var(--gray-700);
    cursor: pointer;
    transition: all 0.2s;
}

.filter-chip:hover {
    border-color: var(--primary);
    color: var(--primary);
}

.filter-chip.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

/* Search Input */
.search-wrapper {
    position: relative;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius-sm);
    font-size: 0.875rem;
    transition: all 0.2s;
    background: white;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: var(--gray-400);
    pointer-events: none;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    color: var(--gray-300);
}

.empty-state-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
}

.empty-state-description {
    font-size: 0.875rem;
    color: var(--gray-600);
    max-width: 400px;
    margin: 0 auto;
}

/* Loading State */
.skeleton {
    background: linear-gradient(90deg, var(--gray-100) 25%, var(--gray-200) 50%, var(--gray-100) 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
    border-radius: var(--radius-sm);
}

@keyframes shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* Stats Section */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

@media (min-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow);
    border: 1px solid var(--gray-100);
    text-align: center;
}

.stat-value {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--gray-600);
    font-weight: 500;
}

/* Responsive Adjustments */
@media (max-width: 767px) {
    .event-card-image {
        height: 180px;
    }
    
    .event-title {
        font-size: 1rem;
    }
    
    .filter-bar {
        padding: 0.75rem;
    }
}

/* Animations */
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

/* Smooth transitions */
* {
    -webkit-tap-highlight-color: transparent;
}

button, a, .month-pill, .filter-chip {
    user-select: none;
    -webkit-user-select: none;
}
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- Hero Section --}}
    <section class="calendar-hero py-16 md:py-20">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full mb-4">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xs font-semibold text-white uppercase tracking-wider">{{ __('site.event_calendar') }}</span>
                </div>
                
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 leading-tight">
                    {{ __('site.events_activities_cilacap') }}
                </h1>
                
                <p class="text-base md:text-lg text-white/90 max-w-2xl mx-auto mb-8">
                    {{ __('site.events_activities_description') }}
                </p>

                {{-- Stats --}}
                <div class="stats-grid max-w-3xl mx-auto">
                    <div class="stat-card bg-white/10 backdrop-blur-sm border-white/20">
                        <div class="stat-value text-white" id="totalEvents">{{ $events->count() }}</div>
                        <div class="stat-label text-white/80">{{ __('site.total_events') }}</div>
                    </div>
                    <div class="stat-card bg-white/10 backdrop-blur-sm border-white/20">
                        <div class="stat-value text-white" id="festivalCount">{{ $events->where('category', 'festival')->count() }}</div>
                        <div class="stat-label text-white/80">{{ __('site.festival') }}</div>
                    </div>
                    <div class="stat-card bg-white/10 backdrop-blur-sm border-white/20">
                        <div class="stat-value text-white" id="workshopCount">{{ $events->where('category', 'workshop')->count() }}</div>
                        <div class="stat-label text-white/80">{{ __('site.workshop') }}</div>
                    </div>
                    <div class="stat-card bg-white/10 backdrop-blur-sm border-white/20">
                        <div class="stat-value text-white" id="pameranCount">{{ $events->where('category', 'pameran')->count() }}</div>
                        <div class="stat-label text-white/80">{{ __('site.pameran') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-12">
        <div class="container mx-auto px-4 md:px-6">
            <div class="max-w-7xl mx-auto">
                {{-- Filter & Search Bar --}}
                <div class="filter-bar mb-8">
                    <div class="flex flex-col lg:flex-row gap-4">
                        {{-- Search --}}
                        <div class="flex-1">
                            <div class="search-wrapper">
                                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input 
                                    type="text" 
                                    id="searchInput"
                                    class="search-input" 
                                    placeholder="{{ __('site.search_events') }}"
                                >
                            </div>
                        </div>

                        {{-- Category Filter --}}
                        <div class="filter-group">
                            <span class="text-sm font-medium text-gray-700 hidden md:inline">{{ __('site.category') }}:</span>
                            <button class="filter-chip active" data-category="all">
                                {{ __('site.all_categories') }}
                            </button>
                            <button class="filter-chip" data-category="festival">
                                <span class="inline-block w-2 h-2 rounded-full bg-red-500 mr-1.5"></span>
                                {{ __('site.festival') }}
                            </button>
                            <button class="filter-chip" data-category="workshop">
                                <span class="inline-block w-2 h-2 rounded-full bg-blue-500 mr-1.5"></span>
                                {{ __('site.workshop') }}
                            </button>
                            <button class="filter-chip" data-category="pameran">
                                <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-1.5"></span>
                                {{ __('site.pameran') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Year Filter --}}
                <div class="mb-6">
                    <div class="flex items-center gap-4 flex-wrap">
                        <span class="text-sm font-medium text-gray-700">{{ __('site.year') }}:</span>
                        <div class="flex gap-2 flex-wrap">
                            <button class="year-pill active" data-year="all">{{ __('site.all_years') }}</button>
                            @foreach($availableYears ?? [2025] as $year)
                                <button class="year-pill" data-year="{{ $year }}">{{ $year }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Month Timeline Navigator --}}
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-900">{{ __('site.select_month') }}</h2>
                        <button id="resetFilters" class="text-sm font-medium text-primary hover:text-primary-dark transition-colors">
                            {{ __('site.reset_filter') }}
                        </button>
                    </div>
                    <div class="month-timeline">
                        <button class="month-pill active" data-month="all">{{ __('site.all_months') }}</button>
                        @foreach([__('site.january'), __('site.february'), __('site.march'), __('site.april'), __('site.may'), __('site.june'), __('site.july'), __('site.august'), __('site.september'), __('site.october'), __('site.november'), __('site.december')] as $index => $monthName)
                            <button class="month-pill" data-month="{{ $index + 1 }}" data-month-name="{{ $monthName }}">
                                {{ $monthName }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Events Grid --}}
                <div id="eventsContainer">
                    <div class="events-grid" id="eventsGrid">
                        @forelse($events as $event)
                            <a href="{{ !empty($event['slug']) ? route('events.show', $event['slug']) : '#' }}" 
                               class="event-item block {{ empty($event['slug']) ? 'pointer-events-none' : '' }}"
                               data-month="{{ $event['month'] }}" 
                               data-year="{{ $event['year'] ?? 2025 }}"
                               data-category="{{ $event['category'] }}"
                               data-title="{{ strtolower($event['title']) }}"
                               data-location="{{ strtolower($event['location'] ?? '') }}"
                               data-description="{{ strtolower($event['description'] ?? '') }}">
                                <div class="event-card animate-fade-in">
                                    
                                    {{-- Event Image --}}
                                    <div class="event-card-image">
                                    @if($event['image'])
                                        <img src="{{ \App\Services\ImageUrl::url($event['image']) }}" 
                                             alt="{{ $event['title'] }}" 
                                             loading="lazy">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100">
                                            <svg class="w-16 h-16 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    {{-- Category Badge --}}
                                    <div class="event-category-badge category-{{ $event['category'] }}">
                                        {{ ucfirst($event['category']) }}
                                    </div>
                                </div>

                                {{-- Event Content --}}
                                <div class="event-card-content">
                                    <h3 class="event-title">{{ $event['title'] }}</h3>
                                    
                                    <div class="event-meta">
                                        {{-- Date Range --}}
                                        @if($event['date_range'])
                                            <div class="event-meta-item">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span>{{ $event['date_range'] }}</span>
                                            </div>
                                        @endif
                                        
                                        {{-- Location --}}
                                        @if($event['location'])
                                            <div class="event-meta-item">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span>{{ $event['location'] }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    @if($event['description'])
                                        <p class="event-description">{{ $event['description'] }}</p>
                                    @endif
                                </div>

                                {{-- Event Footer --}}
                                <div class="event-card-footer">
                                    <span class="event-learn-more">
                                        {{ __('site.view_detail') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </span>
                                </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full">
                                <div class="empty-state">
                                    <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <h3 class="empty-state-title">{{ __('site.no_events_found') }}</h3>
                                    <p class="empty-state-description">{{ __('site.no_events_description') }}</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- No Results Message --}}
                    <div id="noResults" class="hidden">
                        <div class="empty-state">
                            <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <h3 class="empty-state-title">{{ __('site.no_results_found') }}</h3>
                            <p class="empty-state-description">{{ __('site.no_results_description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const eventsGrid = document.getElementById('eventsGrid');
    const noResults = document.getElementById('noResults');
    const searchInput = document.getElementById('searchInput');
    const filterChips = document.querySelectorAll('.filter-chip');
    const monthPills = document.querySelectorAll('.month-pill');
    const yearPills = document.querySelectorAll('.year-pill');
    const resetButton = document.getElementById('resetFilters');
    
    let currentFilters = {
        search: '',
        category: 'all',
        month: 'all',
        year: 'all'
    };

    // Filter events
    function filterEvents() {
        const items = eventsGrid.querySelectorAll('.event-item');
        let visibleCount = 0;

        items.forEach(item => {
            const cardMonth = item.dataset.month;
            const cardYear = item.dataset.year || '2025';
            const cardCategory = item.dataset.category;
            const cardTitle = item.dataset.title;
            const cardLocation = item.dataset.location;
            const cardDescription = item.dataset.description;
            
            const searchText = currentFilters.search.toLowerCase();
            const matchesSearch = !searchText || 
                                cardTitle.includes(searchText) || 
                                cardLocation.includes(searchText) ||
                                cardDescription.includes(searchText);
            
            const matchesCategory = currentFilters.category === 'all' || 
                                   cardCategory === currentFilters.category;
            
            const matchesMonth = currentFilters.month === 'all' || 
                               cardMonth == currentFilters.month;
            
            const matchesYear = currentFilters.year === 'all' || 
                              cardYear == currentFilters.year;

            if (matchesSearch && matchesCategory && matchesMonth && matchesYear) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (visibleCount === 0) {
            eventsGrid.style.display = 'none';
            noResults.classList.remove('hidden');
        } else {
            eventsGrid.style.display = 'grid';
            noResults.classList.add('hidden');
        }
    }

    // Search input
    let searchTimeout;
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentFilters.search = e.target.value;
            filterEvents();
        }, 300);
    });

    // Category filter
    filterChips.forEach(chip => {
        chip.addEventListener('click', function() {
            filterChips.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            currentFilters.category = this.dataset.category;
            filterEvents();
        });
    });

    // Year filter
    yearPills.forEach(pill => {
        pill.addEventListener('click', function() {
            yearPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            currentFilters.year = this.dataset.year;
            filterEvents();
        });
    });

    // Month filter
    monthPills.forEach(pill => {
        pill.addEventListener('click', function() {
            monthPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            currentFilters.month = this.dataset.month;
            filterEvents();
        });
    });

    // Reset filters
    resetButton.addEventListener('click', function() {
        currentFilters = {
            search: '',
            category: 'all',
            month: 'all',
            year: 'all'
        };
        
        searchInput.value = '';
        filterChips.forEach(c => c.classList.remove('active'));
        filterChips[0].classList.add('active');
        yearPills.forEach(p => p.classList.remove('active'));
        yearPills[0].classList.add('active');
        monthPills.forEach(p => p.classList.remove('active'));
        monthPills[0].classList.add('active');
        
        filterEvents();
    });

    // Initialize
    filterEvents();
});
</script>
@endpush
@endsection
