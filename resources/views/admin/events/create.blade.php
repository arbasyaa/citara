@extends('layouts.admin')

@section('page-title', 'New Event')

@section('content')
        <div class="max-w-2xl bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h1 class="text-xl font-bold mb-4">New Event</h1>
            <form method="POST" action="{{ route('panel.events.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm">Month</label>
                    <input name="month" class="mt-1 block w-full rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Date Range</label>
                    <input name="date_range" class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Title</label>
                    <input name="title" class="mt-1 block w-full rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Location</label>
                    <input name="location" class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Description</label>
                    <textarea name="description" class="mt-1 block w-full rounded border-gray-300"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Image</label>
                    <input type="file" name="image" id="eventImage" accept="image/*" class="mt-1 block w-full">
                    <img id="eventImagePreview" src="" alt="" class="mt-3 max-h-40 hidden rounded">
                </div>
                <div class="flex justify-end">
                    <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Create</button>
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
