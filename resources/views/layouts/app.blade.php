<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">

        <aside class="w-64 bg-white shadow-lg fixed inset-y-0 left-0 z-50 hidden md:flex flex-col">
            <div class="h-16 flex items-center px-6 bg-blue-600 text-white shadow-md">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <div>
                    <h1 class="font-bold text-lg leading-tight">Konseling</h1>
                    <p class="text-[10px] opacity-90 uppercase tracking-widest">Sekolah</p>
                </div>
            </div>

            <div class="flex-1 py-6 overflow-y-auto">
                @include('layouts.navigation_items')
            </div>

            <div class="p-4 border-t bg-gray-50">
                <a href="{{ route('profile.edit') }}" class="flex items-center mb-3 hover:bg-gray-100 p-2 rounded-lg transition-colors group">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden border border-gray-200 mr-2">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/'.Auth::user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-blue-600 font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-medium text-gray-800 truncate w-32 group-hover:text-blue-600">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex items-center w-full px-3 py-2 text-sm text-red-600 rounded-md hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar Aplikasi
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 md:ml-64 flex flex-col min-h-screen">
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 sticky top-0 z-40">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $header ?? 'Dashboard' }}
                </h2>
                <div class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::now()->format('l, d F Y') }}
                </div>
            </header>

            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
