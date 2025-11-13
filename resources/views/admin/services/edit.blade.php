@extends('layouts.admin')

@section('page-title', 'Edit Service')

@section('content')
        <div class="max-w-2xl bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h1 class="text-xl font-bold mb-4">Edit Service</h1>
            <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm">Title</label>
                    <input name="title" value="{{ $service->title }}" class="mt-1 block w-full rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Description</label>
                    <textarea name="description" class="mt-1 block w-full rounded border-gray-300">{{ $service->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Link</label>
                    <input name="link" value="{{ $service->link }}" class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div class="mb-4">
                    <label class="block text-sm">Image</label>
                    <input type="file" name="image" id="serviceImage" accept="image/*" class="mt-1 block w-full">
                    @if($service->image)
                        <div class="mt-2">
                            <img src="{{ \App\Services\ImageUrl::url($service->image) }}" alt="current" class="max-h-40 rounded">
                        </div>
                    @endif
                    <img id="serviceImagePreview" src="" alt="" class="mt-3 max-h-40 hidden rounded">
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
    const input = document.getElementById('serviceImage');
    const preview = document.getElementById('serviceImagePreview');
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
