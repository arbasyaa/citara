@extends('layouts.public')

@section('title', __('site.destinations_in') . ' ' . $wilayah->nama)

@push('styles')
<style>
    .wilayah-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }
    
    .wilayah-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="30" cy="25" r="1.5" fill="white" opacity="0.1"/><circle cx="70" cy="15" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/><circle cx="85" cy="75" r="1" fill="white" opacity="0.1"/></svg>');
        animation: float 20s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    
    .dest-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    
    .dest-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }
    
    .dest-card:hover .dest-image {
        transform: scale(1.1);
    }
    
    .dest-image {
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .btn-view {
        background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        transition: all 0.3s ease;
    }
    
    .btn-view:hover {
        background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
        transform: translateX(4px);
    }

    /* Parallax + reveal (match site) */
    .section-reveal { opacity: 0; transform: translateY(22px); transition: opacity .6s ease, transform .6s ease; }
    .section-reveal.active { opacity: 1; transform: translateY(0); }
    .section-parallax { position: relative; }
    .section-parallax .parallax-bg { position: absolute; inset: 0; pointer-events: none; }
    .parallax-card { perspective: 1000px; }
    .parallax-card .parallax-target { will-change: transform; transition: transform 0.2s ease-out; }
    .pattern-dots { background-image: radial-gradient(rgba(59,130,246,0.10) 1px, transparent 1px); background-size: 22px 22px; }
    .pattern-waves { background-image: repeating-linear-gradient(0deg, rgba(99,102,241,0.08) 0 2px, transparent 2px 10px); }
</style>
@endpush

@section('content')
    {{-- Professional Hero for Wilayah --}}
    <section class="wilayah-hero -mt-24 py-32 relative section-parallax section-reveal">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl">
                {{-- Breadcrumb --}}
                <nav class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-md rounded-full text-sm mb-8">
                    <a href="{{ route('home') }}" class="text-white/80 hover:text-white">Home</a>
                    <svg class="w-4 h-4 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-white font-medium">{{ $wilayah->nama }}</span>
                </nav>
                
                {{-- Title --}}
                <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-md rounded-full mb-6">
                    <span class="text-white text-sm font-semibold uppercase tracking-wide">Wilayah Wisata</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white mb-6 leading-tight">
                    {{ $wilayah->nama }}
                </h1>
                <p class="text-xl md:text-2xl text-white/90 leading-relaxed max-w-3xl">
                    {{ $wilayah->deskripsi }}
                </p>
                
                {{-- Stats --}}
                <div class="mt-8 inline-flex items-center gap-3 px-6 py-4 bg-white/10 backdrop-blur-md rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-white font-semibold text-lg">{{ $destinasi->total() }} Destinasi Wisata</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Destinations Grid --}}
    <section class="container mx-auto px-6 py-16 section-parallax section-reveal">
        @if($destinasi->isEmpty())
            <div class="text-center py-20">
                <div class="w-32 h-32 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ __('site.no_destinations_area') }}</h3>
                <p class="text-gray-600 mb-8">Belum ada destinasi di wilayah ini</p>
                <a href="{{ route('destinasi.index') }}" class="btn-view inline-flex items-center gap-2 px-8 py-4 text-white rounded-xl font-semibold shadow-lg">
                    Lihat Semua Destinasi
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($destinasi as $dest)
                    <article class="dest-card bg-white rounded-2xl shadow-lg overflow-hidden group parallax-card">
                        <div class="relative h-64 overflow-hidden">
                            @if($dest->foto->isNotEmpty())
                                <img 
                                    src="{{ Storage::url($dest->foto->first()->url) }}"
                                    alt="{{ $dest->nama }}"
                                    class="dest-image w-full h-full object-cover parallax-target"
                                >
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                                {{ $dest->nama }}
                            </h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit($dest->deskripsi, 150) }}
                            </p>
                            @if($dest->alamat_lokasi)
                                <div class="flex items-start text-gray-500 mb-4">
                                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="text-sm">{{ Str::limit($dest->alamat_lokasi, 40) }}</span>
                                </div>
                            @endif
                            <a 
                                href="{{ route('destinasi.show', $dest->slug) }}"
                                class="btn-view inline-flex items-center gap-2 px-6 py-3 text-white rounded-xl font-semibold shadow-lg"
                            >
                                {{ __('site.read_more') }}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-16">
                {{ $destinasi->links() }}
            </div>
        @endif
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries)=>{
        entries.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add('active'); } });
    }, { threshold: 0.1 });
    document.querySelectorAll('.section-reveal').forEach(el=>observer.observe(el));

    let ticking=false; function update(){
        const y=window.pageYOffset;
        document.querySelectorAll('.parallax-bg').forEach(bg=>{
            const s=parseFloat(bg.dataset.speed)||0.4;
            bg.style.transform=`translate3d(0, ${-(y*s)}px, 0)`;
        });
        ticking=false;
    }
    window.addEventListener('scroll', ()=>{ if(!ticking){ requestAnimationFrame(update); ticking=true; } });
    update();

    const maxTilt=6;
    document.querySelectorAll('.parallax-card').forEach(card=>{
        const target = card.querySelector('.parallax-target')||card;
        card.addEventListener('mousemove',(e)=>{
            const r=card.getBoundingClientRect();
            const rx=((e.clientY-r.top)/r.height-.5)*-maxTilt;
            const ry=((e.clientX-r.left)/r.width-.5)*maxTilt;
            target.style.transform=`perspective(800px) rotateX(${rx}deg) rotateY(${ry}deg) scale(1.02)`;
        });
        card.addEventListener('mouseleave',()=>{ target.style.transform='none'; });
    });
});
</script>
@endpush