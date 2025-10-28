<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ __('site.meta_description') }}">
    
    <title>{{ config('app.name') }} - @yield('title', __('site.site_name'))</title>
    
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
        html, body { 
            max-width: 100%; 
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
            margin: 0;
            padding: 0;
        }
        
        /* Remove default spacing */
        main > section:first-child {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
    </style>
</head>
<body class="bg-gray-100 overflow-x-hidden">
    <!-- Header/Navbar -->
    <header class="fixed w-full z-50 transition-all duration-300 bg-transparent" id="navbar">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight text-white transition-colors duration-300" id="nav-logo">
                        {{ __('site.site_name') }}
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="nav-link text-white font-medium hover:text-gray-100 px-3 py-1 rounded-md hover:bg-white/10 transition">{{ __('site.home') }}</a>
                    <a href="{{ route('destinasi.index') }}" class="nav-link text-white font-medium hover:text-gray-100 px-3 py-1 rounded-md hover:bg-white/10 transition">{{ __('site.destinations') }}</a>
                    <a href="#" class="nav-link text-white font-medium hover:text-gray-100 px-3 py-1 rounded-md hover:bg-white/10 transition">{{ __('site.accommodation') }}</a>
                    <a href="#" class="nav-link text-white font-medium hover:text-gray-100 px-3 py-1 rounded-md hover:bg-white/10 transition">{{ __('site.transport') }}</a>

                    <!-- Language switcher -->
                    <div class="flex items-center space-x-1 ml-2 border-l border-white/30 pl-3">
                        <a href="{{ route('lang.switch', 'en') }}" 
                           class="text-white font-medium px-2 py-1 rounded transition {{ app()->getLocale() === 'en' ? 'bg-white/20' : 'hover:bg-white/10' }}">
                            EN
                        </a>
                        <span class="text-white/50">|</span>
                        <a href="{{ route('lang.switch', 'id') }}" 
                           class="text-white font-medium px-2 py-1 rounded transition {{ app()->getLocale() === 'id' ? 'bg-white/20' : 'hover:bg-white/10' }}">
                            ID
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <style>
            /* Stronger solid navbar shadow and backdrop blur when it becomes solid */
            #navbar.bg-white {
                box-shadow: 0 6px 20px -8px rgba(0,0,0,0.35) !important;
                backdrop-filter: blur(6px);
            }
        </style>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ __('site.about_us') }}</h3>
                    <p class="text-gray-400">
                        {{ __('site.about_description') }}
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ __('site.important_links') }}</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">{{ __('site.tourism_map') }}</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">{{ __('site.event_calendar_link') }}</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">{{ __('site.faq') }}</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">{{ __('site.contact') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ __('site.contact_us') }}</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>{{ __('site.tourism_office') }}</li>
                        <li>{{ __('site.address') }}</li>
                        <li>{{ __('site.email') }}</li>
                        <li>{{ __('site.phone') }}</li>
                    </ul>
                </div>
            </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ __('site.site_name') }}. {{ __('site.all_rights_reserved') }}.</p>
            </div>
        </div>
    </footer>
    {{-- Page specific scripts pushed by views --}}
    @stack('scripts')
</body>
</html>