@extends('layouts.public')

@section('title', $akomodasi->nama)

@section('content')
<section class="container mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                @if(!empty($akomodasi->thumbnail))
                    <img src="{{ Storage::url($akomodasi->thumbnail) }}" alt="{{ $akomodasi->nama }}" class="w-full h-64 md:h-80 object-cover rounded-xl mb-6" loading="lazy">
                @endif
                <h1 class="text-3xl font-black mb-2">{{ $akomodasi->nama }}</h1>
                <div class="text-gray-500 mb-4">{{ $akomodasi->tipe }}</div>
                <div class="prose text-gray-700">{!! nl2br(e($akomodasi->deskripsi)) !!}</div>
            </div>
        </div>
        <aside class="bg-white rounded-2xl shadow-lg p-6">
            <div class="text-sm text-gray-500 mb-4">Detail</div>
            @if($akomodasi->lokasi)
                <div class="mb-3"><strong>Lokasi:</strong> {{ $akomodasi->lokasi }}</div>
            @endif
            @if($akomodasi->nomor_telepon)
                <div class="mb-3"><strong>Tel:</strong> {{ $akomodasi->nomor_telepon }}</div>
            @endif
            @if($akomodasi->url_situs_web)
                <div><a href="{{ $akomodasi->url_situs_web }}" target="_blank" rel="noopener" class="text-blue-600">Website</a></div>
            @endif
        </aside>
    </div>
</section>
@endsection
