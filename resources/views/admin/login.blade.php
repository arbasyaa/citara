@extends('layouts.auth')

@section('auth.content')
    <div class="w-full max-w-sm mx-auto">
        <div class="bg-white/95 backdrop-blur rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Panel Admin</h1>
                <p class="text-sm text-gray-500">Masuk untuk mengelola konten</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
                    Email atau Kata Sandi tidak valid.
                </div>
            @endif

            <form method="POST" action="{{ route('panel.login.post') }}" class="space-y-4" aria-label="Administrator login">
                @csrf
                {{-- REVISI: Tambahkan Field Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1 relative">
                        <input id="email" name="email" type="email" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Masukkan email admin" value="{{ old('email') }}" autofocus>
                    </div>
                </div>

                {{-- Field Password (Disesuaikan posisinya) --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <div class="mt-1 relative">
                        <input id="password" name="password" type="password" required class="block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Masukkan kata sandi" autocomplete="current-password">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" aria-label="Tampilkan kata sandi">
                            <svg id="toggleIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
                {{-- END Field Password --}}
                
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-blue-600 text-white font-medium rounded-lg shadow-sm hover:bg-blue-700 transition">Masuk</button>
                <div class="text-center text-sm">
                    <a href="/" class="text-gray-500 hover:underline">Kembali ke situs</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('togglePassword');
            const pwd = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (toggle && pwd && icon) {
                toggle.addEventListener('click', function() {
                    const showing = pwd.type === 'text';
                    pwd.type = showing ? 'password' : 'text';
                    toggle.setAttribute('aria-label', showing ? 'Tampilkan kata sandi' : 'Sembunyikan kata sandi');
                    // swap icon paths
                    if (showing) {
                        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                    } else {
                        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242" />';
                    }
                });
            }
        });
    </script>
    @endpush
@endsection