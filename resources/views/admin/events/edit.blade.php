@extends('layouts.admin')

@section('page-title', 'Edit Event')

@section('content')
        <div class="max-w-2xl bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h1 class="text-xl font-bold mb-4">Edit Event</h1>
            <form method="POST" action="{{ route('panel.events.update', $event) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm">Month</label>
                    <input name="month" value="{{ $event->month }}" class="mt-1 block w-full rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Date Range</label>
                    <input name="date_range" value="{{ $event->date_range }}" class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Title</label>
                    <input name="title" value="{{ $event->title }}" class="mt-1 block w-full rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Location</label>
                    <input name="location" value="{{ $event->location }}" class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Description</label>
                    <textarea name="description" class="mt-1 block w-full rounded border-gray-300">{{ $event->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Image</label>
                    <input type="file" name="image" id="eventImage" accept="image/*" class="mt-1 block w-full">
                    @if($event->image)
                        <div class="mt-2">
                            <img src="{{ \App\Services\ImageUrl::url($event->image) }}" alt="current" class="max-h-40 rounded">
                        </div>
                    @endif
                    <img id="eventImagePreview" src="" alt="" class="mt-3 max-h-40 hidden rounded">
                </div>
                <div class="flex justify-end">
                    <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Save</button>
                </div>
            </form>
        </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const input = document.getElementById('eventImage');
    const preview = document.getElementById('eventImagePreview');
    if (!input) return;
    input.addEventListener('change', function(e){
        const file = e.target.files && e.target.files[0];
        if (!file) { preview.src = ''; preview.classList.add('hidden'); return; }
        const url = URL.createObjectURL(file);
        preview.src = url; preview.classList.remove('hidden');
    });
});
</script>
@endpush
