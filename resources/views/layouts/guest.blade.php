<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-primary">
        <div class="min-h-screen flex flex-col justify-center items-center py-12">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-gradient-to-br from-primary via-slate-800 to-slate-900"></div>
            
            <!-- Content -->
            <div class="relative z-10 w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <a href="/" class="inline-block p-2 rounded-lg" style="background-color: rgba(255, 255, 255, 0.15);">
                        <x-logo variant="nobg" size="h-16" :showText="false" />
                    </a>
                    <h1 class="text-3xl font-bold text-white mt-4 drop-shadow-lg">YuAUCT</h1>
                    <p class="text-gray-200 text-sm mt-2 font-medium">Platform Lelang Online Terpercaya</p>
                </div>

                <!-- Auth Card -->
                <div class="bg-white shadow-2xl rounded-2xl px-8 py-8 border border-gray-200">
                    {{ $slot }}
                </div>

                <!-- Footer Link -->
                <div class="text-center mt-6">
                    <a href="{{ route('home') }}" class="text-gray-200 hover:text-accent transition-colors text-sm font-medium">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
