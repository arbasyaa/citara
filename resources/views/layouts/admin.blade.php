<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
    <style>
        .sidebar-active {
            background-color: rgb(31, 41, 55);
            color: white;
            border-left: 4px solid rgb(99, 102, 241);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-gray-900 text-gray-200 w-64 min-h-screen flex flex-col shadow-xl">
            <div class="px-6 py-5 border-b border-gray-800 bg-gradient-to-r from-gray-900 to-gray-800">
                <a href="{{ route('panel.dashboard') }}" class="flex items-center space-x-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600 text-white font-bold">{{ strtoupper(substr(config('app.name'),0,1)) }}</span>
                    <div>
                        <p class="text-lg font-semibold leading-5">Admin Panel</p>
                        <p class="text-xs text-gray-400">{{ config('app.name') }}</p>
                    </div>
                </a>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1">
                <a href="{{ route('panel.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('panel.wilayah.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.wilayah.*') ? 'sidebar-active' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h7"></path></svg>
                    <span>Wilayah</span>
                </a>
                <a href="{{ route('panel.destinasi.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.destinasi.*') ? 'sidebar-active' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                    <span>Destinasi</span>
                </a>
                {{-- Layanan (services) panel removed from lightweight panel; use /admin for full services management --}}
                <a href="{{ route('panel.events.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.events.*') ? 'sidebar-active' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Kalender</span>
                </a>
                <a href="{{ route('panel.akomodasi.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.akomodasi.*') ? 'sidebar-active' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 16V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8m18 0a2 2 0 01-2 2H5a2 2 0 01-2-2m18 0V8m-18 8V8"></path></svg>
                    <span>Akomodasi</span>
                </a>
                <a href="{{ route('panel.transportasi.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.transportasi.*') ? 'sidebar-active' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13h18M5 7h14a2 2 0 012 2v10h-2a2 2 0 01-2-2v-1H7v1a2 2 0 01-2 2H3V9a2 2 0 012-2z"></path></svg>
                    <span>Transportasi</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-800 mt-auto">
                <div class="mb-3">
                    <a href="{{ route('home') }}" class="w-full flex items-center gap-2 px-3 py-2 rounded-md text-sm text-gray-300 hover:bg-gray-800 hover:text-white">
                        <svg class="h-4 w-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l7-9 7 9M12 22V9"></path></svg>
                        <span>Back to homepage</span>
                    </a>
                </div>
                <form method="POST" action="{{ route('panel.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-md text-sm text-red-300 hover:bg-red-900/20">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 min-w-0">
            <!-- Topbar -->
            <header class="bg-white border-b sticky top-0 z-30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center gap-3">
                            <button id="sidebarToggle" class="lg:hidden inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100" aria-label="Toggle sidebar">
                                <svg class="h-6 w-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            <h2 class="text-lg font-semibold text-gray-900">@yield('page-title','Admin Panel')</h2>
                        </div>
                        <div class="hidden md:flex items-center gap-3">
                            <button class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C8.67 6.165 7 8.388 7 11v3.159c0 .538-.214 1.055-.595 1.436L5 17h5"></path></svg>
                            </button>
                            <div class="h-8 w-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-sm font-semibold">A</div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-4">
                            {{ session('warning') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        // Simple sidebar toggle for small screens
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            if (btn && sidebar) {
                btn.addEventListener('click', () => {
                    sidebar.classList.toggle('-ml-64');
                });
            }
        });
    </script>
    @livewireScripts
</body>
</html>