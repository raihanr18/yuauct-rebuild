<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'YuAUCT') }} - @yield('title', 'Lelang Online Terpercaya')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral min-h-screen">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-18">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <a href="{{ route('home') }}" class="block p-2 mt-2 rounded-lg" style="background-color: rgba(255, 255, 255, 0.15);">
                                <x-logo variant="nobg" size="h-12" :showText="false" />
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('home') ? 'border-b-2 border-accent text-accent' : 'text-white hover:text-accent' }} transition-colors">
                                Beranda
                            </a>
                            <a href="{{ route('auctions.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('auctions.*') ? 'border-b-2 border-accent text-accent' : 'text-white hover:text-accent' }} transition-colors">
                                Lelang
                            </a>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                            <div class="ml-3 relative" x-data="{ open: false }">
                                <div>
                                    <button @click="open = !open" class="flex items-center text-sm rounded-md text-white hover:text-accent focus:outline-none focus:text-accent transition duration-150 ease-in-out">
                                        <div>{{ Auth::user()->name }}</div>
                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </div>

                                <div x-show="open" @click="open = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>

                                <div x-show="open" style="display: none;" class="absolute z-20 right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl">
                                    @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                                        <a href="{{ route('staff.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">Dashboard Staff</a>
                                    @else
                                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">Dashboard</a>
                                    @endif
                                    
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">Profil</a>
                                    
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="space-x-4">
                                <a href="{{ route('login') }}" class="text-white hover:text-accent transition-colors">Masuk</a>
                                <a href="{{ route('register') }}" class="btn-accent">Daftar</a>
                            </div>
                        @endauth
                    </div>

                    <!-- Hamburger (Mobile) -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-accent focus:outline-none focus:text-accent transition duration-150 ease-in-out" x-data="{ open: false }">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @isset($slot)
                {{ $slot }}
            @else
                @yield('content')
            @endisset
        </main>

        <!-- Footer -->
        <footer class="footer mt-12">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="inline-block p-2 rounded-lg" style="background-color: rgba(255, 255, 255, 0.08);">
                            <x-logo variant="nobg" size="h-10" :showText="false" />
                        </div>
                        <p class="mt-4 text-gray-300">
                            Platform lelang online terpercaya untuk barang antik dan koleksi langka. 
                            Temukan dan tawarkan harga terbaik untuk item favorit Anda.
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-gray-200 tracking-wider uppercase">Navigasi</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-accent transition-colors">Beranda</a></li>
                            <li><a href="{{ route('auctions.index') }}" class="text-gray-300 hover:text-accent transition-colors">Lelang</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-gray-200 tracking-wider uppercase">Kontak</h3>
                        <ul class="mt-4 space-y-4">
                            <li class="text-gray-300">Email: info@yuauct.com</li>
                            <li class="text-gray-300">Phone: +62 123 456 789</li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-8 border-t border-gray-700 pt-8">
                    <p class="text-center text-gray-300">
                        &copy; {{ date('Y') }} YuAUCT. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
