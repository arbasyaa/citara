@extends('layouts.public')

@section('title', __('site.accommodation'))

@push('styles')
<style>
    .dest-hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden; }
    .dest-hero::before { content: ''; position: absolute; inset: 0; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="30" cy="25" r="1.5" fill="white" opacity="0.1"/><circle cx="70" cy="15" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/><circle cx="85" cy="75" r="1" fill="white" opacity="0.1"/></svg>'); animation: float 20s ease-in-out infinite; }
    @keyframes float { 0%,100%{ transform: translateY(0);} 50%{ transform: translateY(-20px);} }
    .search-bar { backdrop-filter: blur(20px); background: rgba(255,255,255,0.95); box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
    .dest-card { transition: all .4s cubic-bezier(0.4,0,0.2,1); overflow: hidden; }
    .dest-card:hover { transform: translateY(-12px); box-shadow: 0 25px 50px rgba(0,0,0,0.15); }
    .dest-card:hover .dest-image { transform: scale(1.1); }
    .dest-image { transition: transform .6s cubic-bezier(0.4,0,0.2,1); }
    .badge { backdrop-filter: blur(10px); background: rgba(255,255,255,0.95); border: 1px solid rgba(255,255,255,0.3); }
    .btn-view { background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); transition: all .3s ease; }
    .btn-view:hover { background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%); transform: translateX(4px); }
    .section-reveal { opacity: 0; transform: translateY(22px); transition: opacity .6s ease, transform .6s ease; }
    .section-reveal.active { opacity: 1; transform: translateY(0); }
</style>
@endpush

@section('content')
    <!-- Hero -->
    <section class="dest-hero -mt-24 py-32 relative section-reveal">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center text-white">
                <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-md rounded-full mb-6">
                    <span class="text-sm font-semibold uppercase tracking-wide">Jelajahi Cilacap</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight">{{ __('site.accommodation') }}</h1>
                <p class="text-xl md:text-2xl text-white/90 leading-relaxed">{{ __('site.accommodation_subtitle') }}</p>
            </div>
        </div>
    </section>

    <!-- Search -->
    <section class="container mx-auto px-6 -mt-8 relative z-20">
        <div class="search-bar rounded-2xl p-6 max-w-4xl mx-auto">
            <form action="{{ route('akomodasi.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('site.search') }} {{ strtolower(__('site.accommodation')) }}..." class="w-full px-6 py-4 rounded-xl text-gray-800 focus:outline-none bg-gray-50 border-2 border-transparent focus:border-blue-500 text-lg transition-all">
                </div>
                <button type="submit" class="btn-view px-8 py-4 text-white rounded-xl font-semibold text-lg shadow-lg">
                    <span class="flex items-center gap-2 justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        {{ __('site.search') }}
                    </span>
                </button>
            </form>
        </div>
    </section>

    <!-- Grid -->
    <section class="container mx-auto px-6 py-16 section-reveal">
        @if($items->isEmpty())
            <div class="text-center py-20">
                <div class="w-32 h-32 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ __('site.no_accommodation') }}</h3>
                <p class="text-gray-600">{{ __('site.try_other_keywords') }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($items as $a)
                    <article class="dest-card bg-white rounded-2xl shadow-lg overflow-hidden group">
                        <div class="relative h-64 overflow-hidden">
                            @if(!empty($a->thumbnail))
                                <img src="{{ Storage::url($a->thumbnail) }}" alt="{{ $a->nama }}" class="dest-image w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500"></div>
                            @endif
                            <div class="absolute top-4 right-4">
                                <span class="badge px-4 py-2 rounded-full text-sm font-semibold text-gray-800 shadow-lg">{{ $a->tipe ?: __('site.accommodation') }}</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">{{ $a->nama }}</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($a->deskripsi, 150) }}</p>
                            @if($a->lokasi)
                                <div class="flex items-start text-gray-500 mb-4">
                                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="text-sm">{{ Str::limit($a->lokasi, 40) }}</span>
                                </div>
                            @endif
                            <a href="{{ route('akomodasi.show', $a) }}" class="btn-view inline-flex items-center gap-2 px-6 py-3 text-white rounded-xl font-semibold shadow-lg">
                                {{ __('site.read_more') }}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-16">{{ $items->links() }}</div>
        @endif
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const observer = new IntersectionObserver((entries)=>{ entries.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add('active'); } }); }, { threshold: 0.1 });
    document.querySelectorAll('.section-reveal').forEach(el=>observer.observe(el));
});
</script>
@endpush
