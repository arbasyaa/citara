<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Jelajahi keindahan wisata Cilacap - destinasi wisata, akomodasi, dan transportasi">
    
    <title>{{ config('app.name') }} - @yield('title', 'Wisata Cilacap')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                    },
                },
            },
        }
    </script>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Page specific styles pushed by views --}}
    @stack('styles')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('navbar');
            const navLogo = document.getElementById('nav-logo');
            const navLinks = document.querySelectorAll('.nav-link, .container a');

            // initialize as transparent over hero
            function makeTransparent() {
                navbar.classList.remove('bg-white', 'shadow');
                navbar.classList.add('bg-transparent');
                if (navLogo) {
                    navLogo.classList.add('text-white');
                    navLogo.classList.remove('text-gray-900');
                }
                navLinks.forEach(link => {
                    link.classList.add('text-white');
                    link.classList.remove('text-gray-700');
                });
            }

            function makeSolid() {
                navbar.classList.add('bg-white', 'shadow');
                navbar.classList.remove('bg-transparent');
                if (navLogo) {
                    navLogo.classList.remove('text-white');
                    navLogo.classList.add('text-gray-900');
                }
                navLinks.forEach(link => {
                    link.classList.remove('text-white');
                    link.classList.add('text-gray-700');
                });
            }

            const hero = document.getElementById('hero');
            if (hero && navbar) {
                // Start transparent
                makeTransparent();

                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // hero visible -> transparent navbar
                            makeTransparent();
                        } else {
                            // hero not visible -> solid navbar
                            makeSolid();
                        }
                    });
                }, { root: null, threshold: 0, rootMargin: '-60px 0px 0px 0px' });

                observer.observe(hero);
            } else {
                // fallback for pages without hero
                makeSolid();
            }
        });
    </script>
    <style>
        /* Prevent accidental horizontal scroll caused by off-canvas transforms or wide elements */
        html, body { max-width: 100%; overflow-x: hidden; }
    </style>
</head>
<body class="bg-gray-100 overflow-x-hidden min-h-screen flex flex-col">
    <!-- Header/Navbar -->
    <header class="fixed w-full z-50 transition-all duration-300 bg-transparent" id="navbar">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-white transition-colors duration-300" id="nav-logo">
                        Wisata Cilacap
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="nav-link text-white hover:text-gray-100">Beranda</a>
                    <a href="{{ route('destinasi.index') }}" class="nav-link text-white hover:text-gray-100">Destinasi</a>
                    <a href="#" class="nav-link text-white hover:text-gray-100">Akomodasi</a>
                    <a href="#" class="nav-link text-white hover:text-gray-100">Transportasi</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1 pt-24">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-auto">
        <div class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Tentang Kami</h3>
                    <p class="text-gray-400">
                        Portal wisata resmi Kabupaten Cilacap, menyajikan informasi lengkap tentang destinasi wisata, akomodasi, dan transportasi.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Tautan Penting</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Peta Wisata</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Kalender Event</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>Dinas Pariwisata Kabupaten Cilacap</li>
                        <li>Jl. Raya Cilacap</li>
                        <li>Email: info@wisatacilacap.id</li>
                        <li>Tel: (0282) 123456</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Wisata Cilacap. All rights reserved.</p>
            </div>
        </div>
    </footer>
    {{-- Page specific scripts pushed by views --}}
    @stack('scripts')
</body>
</html>