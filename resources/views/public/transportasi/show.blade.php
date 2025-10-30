@extends('layouts.public')

@section('title', $transportasi->nama)

@section('content')
<section class="container mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                @if(!empty($transportasi->thumbnail))
                    <img src="{{ Storage::url($transportasi->thumbnail) }}" alt="{{ $transportasi->nama }}" class="w-full h-64 md:h-80 object-cover rounded-xl mb-6" loading="lazy">
                @endif
                <h1 class="text-3xl font-black mb-2">{{ $transportasi->nama }}</h1>
                <div class="text-gray-500 mb-4">{{ $transportasi->tipe }}</div>
                <div class="prose text-gray-700">{!! nl2br(e($transportasi->deskripsi)) !!}</div>
            </div>
        </div>
        <aside class="bg-white rounded-2xl shadow-lg p-6">
            <div class="text-sm text-gray-500 mb-4">Detail</div>
            @if($transportasi->rute)
                <div class="mb-3"><strong>Rute:</strong> {{ $transportasi->rute }}</div>
            @endif
        </aside>
    </div>
</section>
@endsection
