<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ __('site.meta_description') }}">
    
    <title>{{ config('app.name') }} - @yield('title', __('site.site_name'))</title>
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
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
        // Optimized navbar with passive scroll listener and RAF
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('navbar');
            const navLogo = document.getElementById('nav-logo');
            const navLinks = document.querySelectorAll('.nav-link, .container a');
            const hero = document.getElementById('hero');

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

            if (hero && navbar) {
                makeTransparent();
                
                // Use IntersectionObserver instead of scroll for better performance
                // compute rootMargin based on navbar height to avoid hardcoded offsets
                const navRect = navbar.getBoundingClientRect();
                const navHeight = Math.ceil(navRect.height) || parseInt(getComputedStyle(document.documentElement).getPropertyValue('--navbar-height')) || 64;
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            makeTransparent();
                        } else {
                            makeSolid();
                        }
                    });
                }, { 
                    root: null, 
                    threshold: 0, 
                    rootMargin: `-${navHeight}px 0px 0px 0px` 
                });

                observer.observe(hero);
            } else {
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
        
        /* Ensure main content sits below fixed navbar. JS will set --navbar-height */
        :root { --navbar-height: 64px; }
        main { padding-top: var(--navbar-height); }
        
        /* Reduce animations on mobile for better performance */
        @media (max-width: 768px) {
            .parallax-target,
            .news-card,
            .area-card img,
            .section-reveal,
            .slide-up {
                transform: none !important;
                animation: none !important;
            }
        }
        
        /* Respect user's motion preferences */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 overflow-x-hidden">
    <!-- Header/Navbar -->
    <header class="fixed w-full z-50 transition-all duration-300 bg-transparent" id="navbar">
        <nav class="max-w-screen-xl mx-auto px-4 md:px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center shrink-0">
                    <a href="{{ route('home') }}" class="text-xl sm:text-2xl font-bold tracking-tight text-white transition-colors duration-300 leading-tight" id="nav-logo">
                        <span class="block">Cilacap tourism &amp; Travel</span>
                    </a>
                </div>

                <!-- Desktop navigation -->
                <div class="hidden lg:flex items-center space-x-2 xl:space-x-3">
                    <a href="{{ route('home') }}" class="nav-link text-white font-medium hover:text-gray-100 px-3 py-2 rounded-md hover:bg-white/10 transition text-sm xl:text-base">{{ __('site.home') }}</a>
                    <a href="{{ route('destinasi.index') }}" class="nav-link text-white font-medium hover:text-gray-100 px-3 py-2 rounded-md hover:bg-white/10 transition text-sm xl:text-base">{{ __('site.destinations') }}</a>
                    <a href="{{ route('akomodasi.index') }}" class="nav-link text-white font-medium hover:text-gray-100 px-3 py-2 rounded-md hover:bg-white/10 transition text-sm xl:text-base">{{ __('site.accommodation') }}</a>
                    <a href="{{ route('transportasi.index') }}" class="nav-link text-white font-medium hover:text-gray-100 px-3 py-2 rounded-md hover:bg-white/10 transition text-sm xl:text-base">{{ __('site.transport') }}</a>
                    <a href="{{ route('events.calendar', ['year' => 2025, 'month' => 1]) }}" class="nav-link text-white font-medium hover:text-gray-100 px-3 py-2 rounded-md hover:bg-white/10 transition text-sm xl:text-base">{{ __('site.event_calendar') }}</a>
                    <div class="flex items-center space-x-1 ml-2 pl-3 border-l border-white/30">
                        <a href="{{ route('lang.switch', 'en') }}" class="text-white font-medium px-2 py-1 rounded transition text-xs xl:text-sm {{ app()->getLocale() === 'en' ? 'bg-white/20' : 'hover:bg-white/10' }}">EN</a>
                        <span class="text-white/50 text-xs xl:text-sm">|</span>
                        <a href="{{ route('lang.switch', 'id') }}" class="text-white font-medium px-2 py-1 rounded transition text-xs xl:text-sm {{ app()->getLocale() === 'id' ? 'bg-white/20' : 'hover:bg-white/10' }}">ID</a>
                    </div>
                </div>

                <!-- Mobile hamburger -->
                <button id="navToggle" aria-controls="mobileMenu" aria-expanded="false" aria-label="Toggle navigation" class="lg:hidden inline-flex items-center justify-center rounded-md p-2 text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white">
                    <svg id="navToggleIconOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg id="navToggleIconClose" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Mobile menu panel -->
            <div id="mobileMenu" class="lg:hidden hidden mt-2 rounded-lg bg-white/95 backdrop-blur-sm shadow-lg border border-white/30 divide-y divide-gray-200">
                <div class="py-2 px-2 space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-primary-50">{{ __('site.home') }}</a>
                    <a href="{{ route('destinasi.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-primary-50">{{ __('site.destinations') }}</a>
                    <a href="{{ route('akomodasi.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-primary-50">{{ __('site.accommodation') }}</a>
                    <a href="{{ route('transportasi.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-primary-50">{{ __('site.transport') }}</a>
                    <a href="{{ route('events.calendar', ['year' => 2025, 'month' => 1]) }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-primary-50">{{ __('site.event_calendar') }}</a>
                </div>
                <div class="py-2 px-2 flex items-center gap-2">
                    <span class="text-xs font-medium text-gray-500">LANG</span>
                    <a href="{{ route('lang.switch', 'en') }}" class="px-2 py-1 rounded text-xs font-semibold {{ app()->getLocale() === 'en' ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-primary-50' }}">EN</a>
                    <a href="{{ route('lang.switch', 'id') }}" class="px-2 py-1 rounded text-xs font-semibold {{ app()->getLocale() === 'id' ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-primary-50' }}">ID</a>
                </div>
            </div>
        </nav>
        <script>
            (function() {
                const toggle = document.getElementById('navToggle');
                const menu = document.getElementById('mobileMenu');
                const openIcon = document.getElementById('navToggleIconOpen');
                const closeIcon = document.getElementById('navToggleIconClose');
                if(!toggle || !menu) return;
                function setState(open){
                    menu.classList.toggle('hidden', !open);
                    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                    openIcon.classList.toggle('hidden', open);
                    closeIcon.classList.toggle('hidden', !open);
                    document.body.classList.toggle('overflow-hidden', open);
                }
                toggle.addEventListener('click', () => setState(menu.classList.contains('hidden')));
                // Close on outside click
                document.addEventListener('click', (e) => {
                    if(!menu.classList.contains('hidden') && !menu.contains(e.target) && !toggle.contains(e.target)) {
                        setState(false);
                    }
                });
                // Close on ESC
                document.addEventListener('keydown', (e) => { if(e.key === 'Escape') setState(false); });
            })();
        </script>
        <style>
            /* Stronger solid navbar shadow and backdrop blur when it becomes solid */
            #navbar.bg-white {
                box-shadow: 0 6px 20px -8px rgba(0,0,0,0.35) !important;
                backdrop-filter: blur(6px);
            }
            @media (max-width: 640px) {
                #navbar.bg-white .nav-link { color: #1f2937 !important; }
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
        <script>
            // Measure the navbar and set a CSS variable so content is always
            // padded below the fixed header. Updates on resize and when fonts load.
            (function () {
                const navbar = document.getElementById('navbar');
                if (!navbar) return;

                function updateNavbarHeight() {
                    const rect = navbar.getBoundingClientRect();
                    const height = Math.ceil(rect.height);
                    document.documentElement.style.setProperty('--navbar-height', height + 'px');
                    // Also update observer rootMargin if an observer uses a hardcoded value elsewhere
                    // Some scripts use '-60px 0px 0px 0px' — try to be safe by exposing the value
                    window.__navbarHeight = height;
                }

                // Update on load/resize and when fonts render (font loading can change height)
                window.addEventListener('load', updateNavbarHeight);
                window.addEventListener('resize', updateNavbarHeight);

                // In case fonts are loaded after load event
                if (document.fonts && document.fonts.ready) {
                    document.fonts.ready.then(updateNavbarHeight).catch(() => {});
                }

                // Initial call
                updateNavbarHeight();
            })();
        </script>
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