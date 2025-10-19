@extends('layouts.admin')

@section('page-title', 'Services')

@section('content')
    <div class="bg-white p-6 rounded shadow-sm">
        <h3 class="font-semibold">Services management</h3>
        <p class="text-sm text-gray-600 mt-2">The lightweight panel doesn't manage services. Use the main admin area (/admin/services) for full CRUD.</p>
        <div class="mt-4">
            <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Go to admin services</a>
        </div>
    </div>
@endsection
