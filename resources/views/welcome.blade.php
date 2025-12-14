<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Konseling Sekolah') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

    <nav class="bg-white border-b border-gray-100 fixed w-full z-50 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center text-blue-600 font-bold text-xl gap-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span>E-Konseling</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-blue-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 hover:text-blue-600">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-white pt-24 pb-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

                <div class="text-center md:text-left z-10">
                    <span class="text-blue-600 font-bold tracking-wide uppercase text-sm bg-blue-50 px-3 py-1 rounded-full">Sistem Manajemen Sekolah</span>
                    <h1 class="mt-4 text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">
                        Layanan Bimbingan & <br>
                        <span class="text-blue-600">Konseling Modern</span>
                    </h1>
                    <p class="mt-4 text-lg text-gray-500">
                        Platform terintegrasi untuk siswa, guru BK, dan wali kelas. Curhat aman, booking jadwal mudah, dan akses materi edukasi kesehatan mental kapan saja.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1">
                                Masuk Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1">
                                Mulai Konseling
                            </a>
                            <a href="#fitur" class="px-8 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition">
                                Pelajari Fitur
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute top-0 -right-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                    <div class="absolute -bottom-8 -left-4 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                    <div class="relative bg-white border border-gray-100 rounded-2xl shadow-2xl p-6 rotate-2 hover:rotate-0 transition duration-500">
                        <div class="flex items-center gap-4 mb-4 border-b pb-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">👤</div>
                            <div>
                                <div class="h-2 w-24 bg-gray-200 rounded mb-1"></div>
                                <div class="h-2 w-16 bg-gray-200 rounded"></div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="h-20 bg-blue-50 rounded-lg p-3">
                                <div class="flex gap-2">
                                    <div class="w-8 h-8 bg-blue-200 rounded-md"></div>
                                    <div class="flex-1">
                                        <div class="h-2 w-full bg-blue-200 rounded mb-1"></div>
                                        <div class="h-2 w-2/3 bg-blue-200 rounded"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="h-20 bg-green-50 rounded-lg p-3">
                                <div class="flex gap-2">
                                    <div class="w-8 h-8 bg-green-200 rounded-md"></div>
                                    <div class="flex-1">
                                        <div class="h-2 w-full bg-green-200 rounded mb-1"></div>
                                        <div class="h-2 w-2/3 bg-green-200 rounded"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 text-center">
                            <span class="px-4 py-2 bg-gray-900 text-white rounded-lg text-xs font-bold">Booking Jadwal</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="fitur" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Fitur Unggulan</h2>
                <p class="mt-2 text-gray-500">Semua kebutuhan konseling sekolah dalam satu aplikasi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Booking Online</h3>
                    <p class="text-gray-500 text-sm">Siswa dapat memilih jadwal konseling yang tersedia tanpa harus antre atau cari guru manual.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Jurnal & Materi</h3>
                    <p class="text-gray-500 text-sm">Tulis jurnal harian privat atau publik, dan akses materi edukasi kesehatan mental.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Forum Diskusi</h3>
                    <p class="text-gray-500 text-sm">Ruang diskusi aman dan positif yang dimoderasi langsung oleh Guru BK.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">© {{ date('Y') }} E-Konseling Sekolah. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0 text-gray-400">
                <a href="#" class="hover:text-blue-600">Privacy Policy</a>
                <a href="#" class="hover:text-blue-600">Terms of Service</a>
            </div>
        </div>
    </footer>

    <style>
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>
</body>
</html>
