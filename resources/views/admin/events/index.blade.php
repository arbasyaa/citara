@extends('layouts.admin')

@section('page-title', 'Events')

@section('content')
        <div class="flex flex-wrap gap-3 justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Calendar Events</h1>
            <a href="{{ route('panel.events.create') }}" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">New Event</a>
        </div>
        @if(session('success'))<div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-3">{{ session('success') }}</div>@endif
        <table class="min-w-full bg-white shadow rounded overflow-hidden">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left bg-gray-50">Month</th>
                    <th class="px-4 py-3 text-left bg-gray-50">Title</th>
                    <th class="px-4 py-3 text-left bg-gray-50">Date Range</th>
                    <th class="px-4 py-3 text-left bg-gray-50">Destinasi / Lokasi</th>
                    <th class="px-4 py-3 bg-gray-50">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $event->month }}</td>
                    <td class="px-4 py-2">{{ $event->title }}</td>
                    <td class="px-4 py-2">{{ $event->date_range ?? 'TBA' }}</td>
                    <td class="px-4 py-2">
                        @if($event->destinasi)
                            <a href="{{ route('destinasi.show', $event->destinasi->slug) }}" target="_blank" class="text-indigo-600 hover:underline">
                                {{ $event->destinasi->nama }}
                            </a>
                        @else
                            {{ $event->location ?? '-' }}
                        @endif
                    </td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('panel.events.edit', $event) }}" class="text-indigo-600 hover:text-indigo-800 mr-2">Edit</a>
                        <form method="POST" action="{{ route('panel.events.destroy', $event) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-rose-600 hover:text-rose-800">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
@endsection
