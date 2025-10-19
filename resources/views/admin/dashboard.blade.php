@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
    <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <a href="{{ route('panel.events.index') }}" class="group rounded-xl overflow-hidden shadow bg-gradient-to-br from-emerald-500 to-teal-600 text-white">
            <div class="p-5 flex items-center justify-between">
                <div>
                    <div class="text-sm opacity-80">Events</div>
                    <div class="text-3xl font-bold mt-1">{{ $events->count() }}</div>
                </div>
                <svg class="h-10 w-10 opacity-80 group-hover:opacity-100 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </a>

    <a href="{{ route('panel.destinasi.index') }}" class="group rounded-xl overflow-hidden shadow bg-gradient-to-br from-pink-500 to-rose-600 text-white">
            <div class="p-5 flex items-center justify-between">
                <div>
                    <div class="text-sm opacity-80">Destinations</div>
                    <div class="text-3xl font-bold mt-1">{{ \App\Models\Destinasi::count() }}</div>
                </div>
                <svg class="h-10 w-10 opacity-80 group-hover:opacity-100 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3 0 2.25 3 5 3 5s3-2.75 3-5c0-1.657-1.343-3-3-3z"></path></svg>
            </div>
        </a>

    <a href="{{ route('panel.wilayah.index') }}" class="group rounded-xl overflow-hidden shadow bg-gradient-to-br from-amber-500 to-orange-600 text-white">
            <div class="p-5 flex items-center justify-between">
                <div>
                    <div class="text-sm opacity-80">Wilayah</div>
                    <div class="text-3xl font-bold mt-1">{{ \App\Models\Wilayah::count() }}</div>
                </div>
                <svg class="h-10 w-10 opacity-80 group-hover:opacity-100 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h8"></path></svg>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-5 border-b">
                <h3 class="font-semibold text-gray-800">Site Analysis</h3>
                <p class="text-sm text-gray-500">Overview of the latest month</p>
            </div>
            <div class="p-6">
                <div class="h-48 bg-gradient-to-br from-gray-50 to-white rounded-lg border border-dashed border-gray-200 flex items-center justify-center text-gray-400">
                    Chart placeholder
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h4 class="font-semibold mb-4">Quick Stats</h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="p-4 rounded-lg bg-gray-50">
                        <div class="text-gray-500">Total Events</div>
                            <div class="text-2xl font-bold">{{ $events->count() }}</div>
                    </div>
                    <div class="p-4 rounded-lg bg-gray-50">
                        <div class="text-gray-500">Total Events</div>
                        <div class="text-2xl font-bold">{{ $events->count() }}</div>
                    </div>
                    <div class="p-4 rounded-lg bg-gray-50">
                        <div class="text-gray-500">Destinations</div>
                        <div class="text-2xl font-bold">{{ \App\Models\Destinasi::count() }}</div>
                    </div>
                    <div class="p-4 rounded-lg bg-gray-50">
                        <div class="text-gray-500">Wilayah</div>
                        <div class="text-2xl font-bold">{{ \App\Models\Wilayah::count() }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h4 class="font-semibold mb-2">Quick Actions</h4>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('panel.events.create') }}" class="px-4 py-2 rounded-md bg-emerald-600 text-white hover:bg-emerald-700">New Event</a>
                    <a href="{{ route('panel.destinasi.index') }}" class="px-4 py-2 rounded-md bg-pink-600 text-white hover:bg-pink-700">Manage Destinations</a>
                </div>
            </div>
        </div>
    </div>
@endsection
